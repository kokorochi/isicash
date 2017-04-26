<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserVerifications extends Model
{
    protected $fillable = [
        'username',
        'token',
        'created_at'
    ];
}
