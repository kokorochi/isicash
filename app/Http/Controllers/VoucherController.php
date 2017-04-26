<?php

namespace App\Http\Controllers;

use App\Order;
use App\Product;
use App\SubCategory;
use App\Voucher;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class VoucherController extends Controller {
    public function index()
    {
        $pages_css[] = 'css/jquery.dataTables.min.css';
        $pages_css[] = 'css/responsive.dataTables.min.css';

        $pages_js[] = 'js/jquery.dataTables.min.js';
        $pages_js[] = 'js/dataTables.responsive.min.js';

        return view('voucher.user-voucher-list', compact('pages_css', 'pages_js'));
    }

    public function getVoucher()
    {
        $input = Input::get();
        for ($page = 0; $page <= 9999; $page++)
        {
            $page_length = $input['length'] * $page;
            if ($page_length == $input['start'])
            {
                break;
            }
        }
        $page++;
        Input::merge(['page' => $page]);

        if (Auth::user())
        {
            $datas = DB::table('orders')
                ->join('order_items', 'order_items.order_id', '=', 'orders.id')
                ->join('vouchers', function ($join)
                {
                    $join->on('vouchers.order_id', '=', 'orders.id')
                        ->on('vouchers.order_item', '=', 'order_items.item');
                })
                ->join('products', 'products.id', '=', 'vouchers.product_id')
                ->join('sub_categories', function ($join)
                {
                    $join->on('sub_categories.category_code', '=', 'products.category_code')
                        ->on('sub_categories.sub_category_code', '=', 'products.sub_category_code');
                })
//                ->select(['orders.*', 'vouchers.*', 'products.*', 'sub_categories.*'])
                ->select(['vouchers.id as vi', 'vouchers.code as vc', 'sub_categories.name as scn', 'products.name as pn', 'vouchers.used as vu'])
                ->where('orders.username', '=', Auth::user()->username);

            if (isset($input['search']['value']))
            {
                $datas = $datas->where(function ($query) use ($input)
                {
                    $query->where('vouchers.code', 'like', '%' . $input['search']['value'] . '%')
                        ->orwhere('sub_categories.name', 'like', '%' . $input['search']['value'] . '%')
                        ->orwhere('products.name', 'like', '%' . $input['search']['value'] . '%');
                });
            }


            if ($input['order'][0]['column'] == 0 || $input['order'][0]['column'] == 1)
            {
                $order_by = 'vouchers.code';
            } elseif ($input['order'][0]['column'] == 2)
            {
                $order_by = 'sub_categories.name';
            } elseif ($input['order'][0]['column'] == 3)
            {
                $order_by = 'products.name';
            } elseif ($input['order'][0]['column'] == 4)
            {
                $order_by = 'vouchers.used';
            }
            $datas = $datas->orderBy($order_by, $input['order'][0]['dir']);

            $datas = $datas->paginate($input['length']);

            $data = [];
            $i = 1;
            foreach ($datas as $item)
            {
                $data['data'][] = [
                    '0' => $item->vi, // VOUCHER ID
                    '1' => decrypt($item->vc), // KODE VOUCHER
                    '2' => $item->scn, // JENIS PRODUK
                    '3' => $item->pn, // NAMA PRODUK
                    '4' => $item->vu == 0 ? 'Baru' : 'Terpakai', // STATUS
                ];
                $i++;
            }

            $count_data = count($data);
            if ($count_data == 0)
            {
                $data['data'] = [];
            }
            $data['draw'] = $input['draw'];
            $data['recordsTotal'] = $datas->total();
            $data['recordsFiltered'] = $datas->total();
            $data = json_encode($data, JSON_PRETTY_PRINT);

            return response($data, 200)->header('Content-Type', 'application/json');
        } else
        {
            $data['data'] = [];
            $data['draw'] = $input['draw'];
            $data['error'] = 'Anda tidak mempunyai hak akses';
            $data['iTotalRecords'] = $data['iTotalDisplayRecords'] = 0;
            $data = json_encode($data, JSON_PRETTY_PRINT);

            return response($data, 401)->header('Content-Type', 'application/json');
        }
    }

    public function updateUsed()
    {
        if (Auth::user())
        {
            $input = Input::get();

            $error = null;
            if (! isset($input['voucher_id']))
            {
                $error = 'Voucher tidak ditemukan';
            } else
            {
                $voucher = Voucher::find($input['voucher_id']);
                if (is_null($voucher))
                {
                    $error = 'Voucher tidak ditemukan';
                }

                $order = $voucher->order()->first();
                if (is_null($order) || $order->username !== Auth::user()->username)
                {
                    $error = 'Voucher tidak ditemukan';
                }
            }

            if (! is_null($error))
            {
                $error = json_encode($error, JSON_PRETTY_PRINT);

                return response($error, 400)->header('Content-Type', 'application/json');
            }

            if ($voucher->used == 0) $voucher->used = 1;
            else $voucher->used = 0;
            $voucher->save();

            $success = 'Voucher telah diupdate';
            $success = json_encode($success, JSON_PRETTY_PRINT);

            return response($success, 200)->header('Content-Type', 'application/json');
        } else
        {
            return response('', 401);
        }
    }
}
