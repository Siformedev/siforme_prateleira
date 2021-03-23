<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RaffleNumbers extends Model
{
    protected $fillable = [
        'raffle_id',
        'number',
        'buyer_name',
        'buyer_phone',
        'buyer_email',
        'purchase_date',
        'forming_id',
        'hash',
        'img',
    ];

    public function raffle()
    {
        return $this->belongsTo(Raffle::class);
    }
}
