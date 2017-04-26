<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderStat extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'order_id',
        'item',
        'status',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
