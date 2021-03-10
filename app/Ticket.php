<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = [
        'event_id',
        'forming_id',
        'code',
        'fps_id',
        'status'
    ];

    public function event()
    {
        return $this->hasOne(Event::class, 'id', 'event_id');
    }
}
