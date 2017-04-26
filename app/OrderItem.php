<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderItem extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'order_id',
        'product_id',
        'product_price_id',
        'item',
        'quantity',
        'total_amount',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
