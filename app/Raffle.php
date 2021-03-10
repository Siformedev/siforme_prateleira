<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Raffle extends Model
{

    public function numbers()
    {
        return $this->hasMany(RaffleNumbers::class);
    }
}
