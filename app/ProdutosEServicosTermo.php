<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProdutosEServicosTermo extends Model
{
    protected $table = 'produtos_e_servicos_termos';

    protected $fillable = [
        'produtos_servicos_id',
        'titulo',
        'conteudo'
    ];

    public function conteudoLimpo()
    {
        return strip_tags($this->conteudo);
    }
}
