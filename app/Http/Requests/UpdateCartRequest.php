<?php

namespace App\Http\Requests;

use App\ShoppingCart;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UpdateCartRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if ($this->input('btn_update_cart') == 1)
        {
            return [
                'quantity.*' => 'required'
            ];
        } else
        {
            return [
                'pin' => 'required'
            ];
        }
    }

    public function messages()
    {
        return [
            'quantity.*.required' => 'Jumlah produk tidak boleh kosong',
            'pin.required'        => 'PIN dibutuhkan untuk melakukan pembelian voucher'
        ];
    }

    protected function getValidatorInstance()
    {
        return parent::getValidatorInstance()->after(function ($validator)
        {
            $this->after($validator);
        });
    }


    public function after($validator)
    {
        $check = $this->checkBeforeSave();
        if (count($check) > 0)
        {
            foreach ($check as $item)
            {
                $validator->errors()->add('alert-danger', $item);
            }
        }
    }

    private function checkBeforeSave()
    {
        $ret = [];

        if ($this->input('btn_update_cart') == 1)
        {
            if (! is_null($this->input('quantity')))
            {
                foreach ($this->input('quantity') as $key => $quantity)
                {
                    if ($quantity == 0)
                    {
                        $ret[] = 'Jumlah produk tidak boleh kosong';
                        break;
                    }
                    $shopping_cart = ShoppingCart::find($key);
                    if (is_null($shopping_cart))
                    {
                        $ret[] = 'Item pada keranjang belanja anda tidak valid';
                        break;
                    }
                    if ($shopping_cart->username != Auth::user()->username)
                    {
                        $ret[] = 'Anda tidak memiliki hak akses atas item tersebut';
                        break;
                    }
                }
            }
        } elseif ($this->input('btn_checkout') == 1)
        {
            $user = Auth::user();
            $shopping_carts = ShoppingCart::where('username', $user->username)->get();
            if ($shopping_carts->isEmpty())
            {
                $ret[] = 'Keranjang belanja anda kosong!';

                return $ret;
            }

            $user_account = $user->userAccount()->first();
            $user_balance = $user_account->balance;
            $total_amount = 0;
            foreach ($shopping_carts as $shopping_cart)
            {
                $product = $shopping_cart->product()->first();
                $product_price = $product->productPrice()->where('date', '<=', Carbon::now()->toDateString())->orderBy('date', 'desc')->first();
                $count_voucher = $product->voucher()->where('order_id', null)->count();

                if ($count_voucher < $shopping_cart->quantity)
                {
                    $ret[] = 'Mohon maaf, stok untuk produk ' . $product->name . ' tidak mencukupi permintaan anda. Sisa stok hanya tinggal = ' . $count_voucher . ' saja.';
                }

                $total_amount = $total_amount + ($product_price->final_price * $shopping_cart->quantity);

            }
            if ($user_balance < $total_amount)
            {
                $ret[] = 'Sisa saldo tidak cukup untuk melakukan pembelian, silahkan melakukan topup terlebih dahulu';

                return $ret;
            }

            if (! is_null($this->input('pin')))
            {
                if (! Hash::check($this->input('pin'), $user_account->pin))
                {
                    $ret[] = 'PIN yang anda masukkan salah';
                }
            }
        } else
        {
            $ret[] = 'Tombol yang anda tekan, salah';
        }

        return $ret;
    }
}
