<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GiftRequests extends Model
{
    protected $fillable = [
        'contract_id',
        'forming_id',
        'total',
        'payment_parcels',
        'payment_id',
        'pdf',
        'status',
    ];

    public function gifts(){
        return $this->hasMany(GiftRequestsGifts::class, 'request_id', 'id');
    }

    public function forming(){
        return $this->hasOne(Forming::class, 'id', 'forming_id');
    }

    public function statusHistoric(){
        return $this->hasMany(GiftRequestsStatusHistoric::class, 'giftrequest_id', 'id');
    }
}
