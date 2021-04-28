<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SimulationRequest extends Model
{
    protected $fillable = [
        'name',
        'email',
        'institution',
        'course',
        'cellphone',
        'commission',
    ];
}
