<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Logs extends Model {

    protected $table = 'logs_table';
    protected $fillable = [
        'id',
        'forming_id',
        'action'
    ];

    function forming() {
        return \Illuminate\Support\Facades\Auth::user()->userable;
    }

}
