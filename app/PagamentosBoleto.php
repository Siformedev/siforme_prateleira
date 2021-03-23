<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PagamentosBoleto extends Model
{
    protected $table = 'pagamentos_boleto';

    protected $fillable = [
        'parcela_pagamento_id',
        'valor_pago',
        'invoice_id',
        'payable_with',
        'due_date',
        'total_cents',
        'paid_cents',
        'status',
        'paid_at',
        'secure_url',
        'taxes_paid_cents',
        'installments',
        'digitable_line',
        'barcode',
        'deleted',
    ];

    public function parcelaPagamento()
    {
        return $this->morphOne(ParcelasPagamentos::class, 'typepaind');
    }

}
