<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductAndService extends Model
{
    protected $table = 'products_and_services';

    protected $fillable = [
        "name",
        "contract_id",
        "description",
        "img",
        "value",
        "maximum_parcels",
        "category_id",
        "reset_igpm",
        "termo_id",
        "date_start",
        "date_end"
    ];

    public function qt_produtos_categorias()
    {
        return $this->morphMany(QtProdutoCategoria::class, 'qual_produto');
    }

    public function termo()
    {
        return $this->hasOne(ProdutosEServicosTermo::class, 'id', 'termo_id');
    }

    public function categories_type(){
        return $this->hasMany(ProductAndServiceCateriesType::class, 'pas_id', 'id');
    }

}
