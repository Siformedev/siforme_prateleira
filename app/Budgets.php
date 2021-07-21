<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Eloquent;


class Budgets extends Eloquent
{
    protected $table = 'budgets';
    protected $fillable = [
        'id',
        'contract_id',
        'linkpdf',
        'pathfile'
    ];

}
