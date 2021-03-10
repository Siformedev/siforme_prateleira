<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AccountPseg extends Model
{
    protected $table = 'account_pseg';
    protected $fillable = [
        'id',
        'app_pseg_id',
        'app_pseg_key',
        'app_pseg_auth',
        'pseg_email',
        'pseg_token',
    ];

}
