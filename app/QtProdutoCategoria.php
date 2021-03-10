<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QtProdutoCategoria extends Model
{
    protected $table = 'qt_produtos_categorias';

    protected $fillable = [
        'category_tipo',
        'category_produto',
        'quantidade',
    ];

    public function qual_produto()
    {
        return $this->morphTo();
    }

    public function categoriaTipos()
    {
        return $this->hasOne(CategoriasTipos::class, 'id', 'category_tipo');
    }


}
