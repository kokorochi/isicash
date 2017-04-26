<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PasswordReset extends Model
{
    protected $fillable = ['username', 'token', 'created_at'];
    public $timestamps = false;
}
