<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FormandoProdutosEServicos extends Model
{
    protected $table = 'formando_produtos_e_servicos';

    protected $fillable = [
        'forming_id',
        'contract_id',
        'name',
        'description',
        'img',
        'value',
        'discounts',
        'parcels',
        'category_id',
        'reset_igpm',
        'amount',
        'amount_invitation',
        'amount_tables',
        'photo_album',
        'payday',
        'termo_id',
        'original_id',
        'events_ids',
    ];

    public function categoriaProduto()
    {
        return $this->belongsTo(CategoriasProdutosEServicos::class, 'category_id', 'id');
    }

    public function qtProdutosCategorias()
    {
        return $this->morphMany(QtProdutoCategoria::class, 'qual_produto');
    }

    public function valorFinal()
    {
        $vl = ($this->value * $this->amount);
        $dc = $this->discounts;
        return ($vl - ($vl * ($dc/100)));
    }

    public function valorComDesconto()
    {
        $vl = ($this->value);
        $dc = $this->discounts;
        return ($vl - ($vl * ($dc/100)));
    }

    public function boletos()
    {
        return $this->hasMany(FormandoProdutosParcelas::class, 'formandos_produtos_id', 'id');
    }

    public function parcelas()
    {
        return $this->hasMany(FormandoProdutosParcelas::class, 'formandos_produtos_id', 'id');
    }

    public function categorias_tipos(){
        return $this->hasMany(FormandoProdutosEServicosCateriasTipos::class, 'fps_id', 'id');
    }

    public function forming()
    {
        return $this->belongsTo(Forming::class, 'forming_id', 'id');
    }
}
