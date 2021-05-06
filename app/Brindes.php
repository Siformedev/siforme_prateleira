<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Eloquent;


class Brindes extends Eloquent
{
    protected $table = 'brindes';
    protected $fillable = [
        'id',
        'contract_id',
        'linkpdf',
        'pathfile'
    ];

}
