<?php

namespace App\Http\Controllers;

use App\Order;
use App\Voucher;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class OrderController extends Controller {

    public function __construct()
    {
        $this->middleware('auth')->except('getOrder');
    }

    public function index()
    {
        $pages_css[] = 'css/jquery.dataTables.min.css';
        $pages_css[] = 'css/responsive.dataTables.min.css';

        $pages_js[] = 'js/jquery.dataTables.min.js';
        $pages_js[] = 'js/dataTables.responsive.min.js';

        return view('invoice.invoice-list', compact('pages_css', 'pages_js'));
    }

    public function getOrder()
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
            $datas = DB::table('orders as o')
                ->join('order_stats', 'order_stats.order_id', '=', 'o.id')
                ->select([
                    'o.id as oi',
                    'o.created_at as oca',
                    'o.order_type as oot',
                    'o.total_amount as ota',
                    'order_stats.status as oss'
                ])
                ->where('o.username', '=', Auth::user()->username);

            if (isset($input['search']['value']))
            {
                $datas = $datas->where(function ($query) use ($input)
                {
                    $query->where('orders.created_at', 'like', '%' . $input['search']['value'] . '%')
                        ->orwhere('orders.order_type', 'like', '%' . $input['search']['value'] . '%')
                        ->orwhere('orders.id', 'like', '%' . $input['search']['value'] . '%')
                        ->orwhere('orders.total_amount', 'like', '%' . $input['search']['value'] . '%')
                        ->orwhere('order_stats.status', 'like', '%' . $input['search']['value'] . '%');
                });
            }

            $datas = $datas->where('order_stats.item', '=', function ($where){
                $where->selectRaw('max(`item`) from `order_stats` where `order_id` = `o`.`id`');
            });

            $order_by = null;
            if ($input['order'][0]['column'] == 0)
            {
                $order_by = 'o.created_at';
            } elseif ($input['order'][0]['column'] == 1)
            {
                $order_by = 'o.order_type';
            } elseif ($input['order'][0]['column'] == 2)
            {
                $order_by = 'o.id';
            } elseif ($input['order'][0]['column'] == 3)
            {
                $order_by = 'o.total_amount';
            } elseif ($input['order'][0]['column'] == 4)
            {
                $order_by = 'order_stats.status';
            }

            if (! is_null($order_by))
                $datas = $datas->orderBy($order_by, $input['order'][0]['dir']);

            $datas = $datas->paginate($input['length']);

            $data = [];
            $i = 1;
            foreach ($datas as $item)
            {
                $data['data'][] = [
                    '0' => $item->oca, // TANGGAL
                    '1' => $item->oot, // JENIS
                    '2' => $item->oi, // ORDER ID
                    '3' => 'Rp.' . number_format($item->ota, 0, ',', '.'), // JUMLAH
                    '4' => $item->oss, // STATUS
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

    public function detail()
    {
        $input = Input::get();
        if (! isset($input['order_id']))
        {
            return abort('404');
        }
        $order = Order::find($input['order_id']);
        if (is_null($order))
        {
            return abort('404');
        }
        
        $this->authorize('view', $order);

        $order_items = $order->orderItem()->get();
        $vouchers = new Collection();
        $i = 1;
        foreach ($order_items as $order_item)
        {
            $voucher = Voucher::where('order_id', $order->id)->where('order_item', $order_item->item)->get();
            foreach ($voucher as $item)
            {
                $item->no = $i++;
                $vouchers->add($item);
            }
        }

        return view('invoice.invoice-detail', compact('order', 'order_items', 'vouchers'));
    }
}
