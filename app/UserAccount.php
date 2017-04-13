<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserAccount extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'email',
        'full_name',
        'phone',
        'dob',
        'sex',
        'verified',
        'status',
        'last_login',
        'pin',
        'balance',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
