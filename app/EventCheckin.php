<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventCheckin extends Model
{
    protected $fillable = [
        'event_id',
        'contract_id',
        'forming_id',
    ];
}
