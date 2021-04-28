<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FormandoProdutosEServicosCateriasTipos extends Model
{
    protected $fillable = [
        'fps_id',
        'category_id',
        'quantity',
    ];
}
