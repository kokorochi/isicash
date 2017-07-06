<?php

namespace App\Http\Controllers;

use App\Http\Requests\ConfirmTopupRequest;
use App\Order;
use App\OrderStat;
use App\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller {
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function topupIndex()
    {
        $this->authorize('topupList', Order::class);

        $datas = DB::table('orders as o')
            ->join('order_stats', 'order_stats.order_id', '=', 'o.id')
            ->select([
                'o.id as id',
                'o.created_at as created_at',
                'o.order_type as order_type',
                'o.total_amount as total_amount',
                'o.date as date',
                'o.username as username',
                'order_stats.status as status'
            ]);

        $datas = $datas->where('order_stats.item', '=', function ($where){
            $where->selectRaw('max(`item`) from `order_stats` where `order_id` = `o`.`id`');
        })->where('order_stats.status', '=', 'WAIT CONFIRMATION');

        $order_to_confirms = $datas->get();

        return view('admin.topup-list', compact('order_to_confirms'));
    }

    public function confirmTopup(ConfirmTopupRequest $request)
    {
        $this->authorize('confirmTopup', Order::class);

        $order = Order::find($request->id);
        $order_stat_item = $order->orderStat()->orderBy('item','desc')->first()->item;

        $order_stat = new OrderStat();
        $order_stat->item = $order_stat_item + 1;
        $order_stat->status = 'DONE';

        $user = User::where('username', $order->username)->first();
        $user_account = $user->userAccount()->first();
        $user_account->balance += $order->total_amount;

        DB::transaction(function() use($order, $order_stat, $user_account){
            $order->orderStat()->save($order_stat);
            $user_account->save();
        });

        $request->session()->flash('alert-success', 'Topup berhasil dikonfirmasi!');

        return redirect()->intended('admin/users/topup');
    }

    public function userTopup()
    {
        $pages_js[] = 'js/jquery.inputmask.bundle.js';

        $user_account = Auth::user()->userAccount()->first();

        return view('topup.user-topup', compact('user_account', 'pages_js'));
    }
}
