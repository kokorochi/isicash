<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Auth extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'type',
        'description'
    ];
}
