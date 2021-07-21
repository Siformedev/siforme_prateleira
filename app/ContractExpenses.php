<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContractExpenses extends Model
{
    protected $fillable = [
        'contract_id',
        'category_id',
        'name',
        'description',
        'value',
        'due_date',
        'payday',
        'billing_file',
        'payment_file',
        'paid',
    ];

}
