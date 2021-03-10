<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Informativo extends Model
{
    protected $table = 'informativos';

    protected $fillable = [
        'contract_id',
        'titulo',
        'descricao',
        'status',
    ];


    function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('d/m/Y H:i');
    }
}
