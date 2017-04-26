<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddCartRequest;
use App\Http\Requests\DeleteCartRequest;
use App\Http\Requests\UpdateCartRequest;
use App\Order;
use App\OrderItem;
use App\OrderStat;
use App\ShoppingCart;
use App\Voucher;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class CartController extends Controller {
    public function __construct()
    {
        $input = Input::get('ajax');
        if ($input != true)
        {
            $this->middleware(function ($request, $next)
            {
                if (! Auth::user())
                {
                    $input = Input::all();
                    if (isset($input['product_id']) && isset($input['quantity']))
                        session([
                            'product_id'    => $input['product_id'],
                            'quantity'      => $input['quantity'],
                            'alert-warning' => 'Mohon melakukan login sebelum menambah produk ke keranjang belanja',
                        ]);
                }
                return $next($request);
            });
        }
        $this->middleware('auth');
    }

    public function showCart()
    {
        $pages_js[] = 'js/jquery.inputmask.bundle.js';

        $shopping_carts = ShoppingCart::where('username', Auth::user()->username)->get();
        if ($shopping_carts->isEmpty())
        {
            $shopping_carts = new Collection();
        }

        return view('cart.cart-detail', compact('shopping_carts', 'pages_js'));
    }

    public function addCart(AddCartRequest $request)
    {
        if ($request->quantity == 0) $request->quantity = 1;

        $shopping_carts = ShoppingCart::where('username', Auth::user()->username)->get();

        $shopping_cart = $shopping_carts->filter(function ($item) use ($request)
        {
            if ($item->product_id == $request->product_id)
            {
                $item->quantity += $request->quantity;

                return $item;
            }
        })->first();
        if (is_null($shopping_cart))
        {
            $shopping_cart = ShoppingCart::where('username', Auth::user()->username)->orderBy('item', 'desc')->first();
            if (is_null($shopping_cart))
            {
                $index_item = 1;
            } else $index_item = $shopping_cart->item + 1;

            $shopping_cart = new ShoppingCart();
            $shopping_cart->username = Auth::user()->username;
            $shopping_cart->item = $index_item;
            $shopping_cart->product_id = $request->product_id;
            $shopping_cart->quantity = $request->quantity;
            $shopping_carts->push($shopping_cart);
        }

        if (! $shopping_carts->isEmpty())
        {
            Auth::user()->shoppingCart()->saveMany($shopping_carts);
        }

        if (isset($request->ajax) && $request->ajax == true)
        {
            $ajax_data['success'] = 'Cart added';
            $ajax_data = json_encode($ajax_data, JSON_PRETTY_PRINT);

            return response($ajax_data, 200)->header('Content-Type', 'application/json');
        } else
        {
            if (is_null(session('product_id')))
            {
                $request->session()->flash('alert-success', 'Produk berhasil ditambahkan ke keranjang');
            }

            return redirect('user/carts');
        }

    }

    public function updateCart(UpdateCartRequest $request)
    {
        if ($request->input('btn_update_cart') == 1)
        {

            // Update Cart
            foreach ($request->input('quantity') as $key => $quantity)
            {
                $shopping_cart = ShoppingCart::find($key);
                $shopping_cart->quantity = $quantity;
                $shopping_cart->save();
            }
            $request->session()->flash('alert-success', 'Keranjang berhasil diupdate');

            return redirect('user/carts');
            //End Update Cart

        } elseif ($request->input('btn_checkout'))
        {

            // Make Order Proceed Checkout
            DB::transaction(function () use ($request)
            {
                $user_account = Auth::user()->userAccount()->first();
                $shopping_carts = ShoppingCart::where('username', Auth::user()->username)->get();

                $order = new Order();
                $order->username = Auth::user()->username;
                $order->order_type = 'BUY';
                $order->date = Carbon::now()->toDateString();
                $order->total_amount = 0;

                $order_items = new Collection();
                $vouchers = new Collection();
                $i = 1;
                foreach ($shopping_carts as $shopping_cart)
                {
                    $product = $shopping_cart->product()->first();
                    $product_price = $product->productPrice()
                        ->where('date', '<=', Carbon::now()->toDateString())
                        ->orderBy('date', 'desc')
                        ->first();

                    $order_item = new OrderItem();
                    $order_item->product_id = $product->id;
                    $order_item->product_price_id = $product_price->id;
                    $order_item->item = $i++;
                    $order_item->quantity = $shopping_cart->quantity;
                    $order_item->total_amount = $product_price->final_price * $shopping_cart->quantity;
                    $order_items->add($order_item);

                    $order->total_amount += $order_item->total_amount;

                    //Generate Voucher
                    $voucher = $product->voucher()->where('order_id', null)->limit($shopping_cart->quantity)->get();
                    foreach ($voucher as $item)
                    {
                        $item->order_item = $order_item->item;
                        $vouchers->add($item);
                    }
                    //End Generate Voucher
                }

                $order->save();
                $order->orderItem()->saveMany($order_items);

                $order_stat = new OrderStat();
                $order_stat->item = 1;
                $order_stat->status = 'DONE';
                $order->orderStat()->save($order_stat);

                $order->voucher()->saveMany($vouchers);

                $user_account->balance -= $order->total_amount;
                $user_account->save();

                ShoppingCart::where('username', Auth::user()->username)->delete();
            });

            // End Make Order Proceed Checkout

            return redirect()->intended('/');
        }

    }

    public function deleteCartItem(DeleteCartRequest $request)
    {
        $shopping_cart = ShoppingCart::find($request->id);
        $shopping_cart->delete();
        $request->session()->flash('alert-success', 'Item berhasil dihapus');

        return redirect('user/carts');
    }
}
