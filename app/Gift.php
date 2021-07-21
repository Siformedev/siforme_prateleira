<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gift extends Model
{
    protected $fillable = [

    ];

    public function photos(){
        return $this->hasMany(GiftPhotos::class);
    }
}
