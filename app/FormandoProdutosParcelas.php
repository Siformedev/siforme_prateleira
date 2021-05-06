<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FormandoProdutosParcelas extends Model
{
    protected $table = 'formandos_produtos_parcelas';

    protected $fillable = [
        'formandos_produtos_id',
        'formandos_id',
        'contrato_id',
        'numero_parcela',
        'dt_vencimento',
        'valor',
        'status',
    ];

    public function pagamento()
    {
        return $this->hasMany(ParcelasPagamentos::class, 'parcela_id', 'id');
    }

    public function formando()
    {
        return $this->hasOne(Forming::class, 'id', 'formandos_id');
    }

    public function pedido()
    {
        return $this->hasOne(FormandoProdutosEServicos::class, 'id', 'formandos_produtos_id');
    }
}
