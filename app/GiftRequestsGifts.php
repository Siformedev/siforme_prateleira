<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GiftRequestsGifts extends Model
{
    protected $fillable = [
        'request_id',
        'original_id',
        'name',
        'photo',
        'description',
        'amount',
        'price',
        'size',
        'model',
    ];
}
