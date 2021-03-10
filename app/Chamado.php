<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Chamado extends Model
{
    protected $table = 'chamados';

    protected $fillable = [
        'forming_id',
        'setor_chamado',
        'assunto_chamado',
        'titulo',
        'descricao',
        'data_limite',
        'status'
    ];

    function getDataLimiteAttribute($value)
    {
        return Carbon::parse($value)->format('d/m/Y');
    }

    function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('d/m/Y');
    }

    public function conversas()
    {
        return $this->hasMany(ChamadoConversa::class, 'chamado_id', 'id');
    }

    public function forming (){
        return $this->hasOne(Forming::class, 'id', 'forming_id');
    }
}
