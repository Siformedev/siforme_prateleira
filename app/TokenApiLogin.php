<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TokenApiLogin extends Model
{
    protected $table = 'token_api_login';
    protected $fillable = [
        'user_id',
        'token',
        'expiration',
        'status',
    ];
}
