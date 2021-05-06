<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PagamentosCartao extends Model
{
    protected $table = 'pagamentos_cartao';

    protected $fillable = [
        'parcela_pagamento_id',
        'items_total_cents',
        'invoice_id',
        'payable_with',
        'status',
        'due_date',
        'total',
        'taxes_paid',
        'total_paid',
        'total_overpaid',
        'paid',
        'secure_id',
        'secure_url',
        'installments',
        'transaction_number',
        'payment_method',
        'paid_at',
    ];

    public function parcelaPagamento()
    {
        return $this->morphOne(ParcelasPagamentos::class, 'typepaind');
    }
}
