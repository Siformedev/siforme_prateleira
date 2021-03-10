<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ChamadoConversa extends Model
{
    protected $table = 'chamado_conversas';

    protected $fillable = [
        'chamado_id',
        'user_id',
        'texto',
    ];

    function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('d/m/Y H:i:s');
    }
}
