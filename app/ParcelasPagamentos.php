<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ParcelasPagamentos extends Model
{
    protected $table = 'parcelas_pagamentos';

    protected $fillable = [
        'parcela_id',
        'valor_pago',
        'deleted',
    ];

    public function typepaind()
    {
        return $this->morphTo();
    }

}
