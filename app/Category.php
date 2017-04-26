<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'category_code',
        'name',
        'created_by',
        'updated_by'
    ];

    public function subCategory()
    {
        return $this->hasMany(SubCategory::class, 'category_code', 'category_code');
    }
}
