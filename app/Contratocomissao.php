<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Eloquent;


class Contratocomissao extends Eloquent
{
    protected $table = 'contratos_comissao';
    protected $fillable = [
        'id',
        'contract_id',
        'linkpdf',
        'pathfile'
    ];

}
