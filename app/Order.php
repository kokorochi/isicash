<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'username',
        'order_type',
        'date',
        'total_amount',
    ];

    public function orderItem()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function orderStat()
    {
        return $this->hasMany(OrderStat::class);
    }

    public function voucher()
    {
        return $this->hasMany(Voucher::class);
    }
}
