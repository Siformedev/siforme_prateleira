<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GiftRequestsStatusHistoric extends Model
{
    protected $fillable = [
        'giftrequest_id',
        'user_id',
        'status',
    ];

    public function user(){
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
