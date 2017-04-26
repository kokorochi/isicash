<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable =[
        'category_id',
        'sub_category_id',
        'name',
        'description',
        'created_by',
        'updated_by'
    ];

    public function productPrice()
    {
        return $this->hasMany(ProductPrice::class);
    }

    public function voucher()
    {
        return $this->hasMany(Voucher::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_code', 'category_code');
    }

    public function shoppingCart()
    {
        return $this->hasMany(ShoppingCart::class);
    }
}
