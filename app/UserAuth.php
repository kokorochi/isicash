<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserAuth extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'auth_type'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function auth()
    {
        return $this->belongsTo(Auth::class, 'auth_type', 'type');
    }
}
