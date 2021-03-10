<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Forming extends Model
{
    protected $table = 'formings';

    protected $fillable = [

            "contract_id",
            "nome",
            "sobrenome",
            "cpf",
            "sexo",
            "date_nascimento",
            "img",
            "rg",
            "cep",
            "logradouro" ,
            "numero",
            "complemento",
            "bairro",
            "cidade",
            "estado",
            "email",
            "telefone_residencial",
            "telefone_celular",
            "nome_do_pai",
            "email_do_pai",
            "telefone_celular_pai",
            "nome_da_mae",
            "email_da_mae",
            "telefone_celular_mae",
            "altura",
            "camiseta",
            "calcado",
            "curso_id",
            "periodo_id",
            "dt_adesao",
            "status",
            "valid",
            "senha"

        ];

    public function user()
    {
        return $this->morphOne(User::class, 'userable');
    }

    public function products()
    {
        return $this->hasMany(FormandoProdutosEServicos::class, 'forming_id', 'id');
    }

    public function course()
    {
        return $this->hasOne(Course::class, 'id', 'curso_id');
    }

    public function contract()
    {
        return $this->hasOne(Contract::class, 'id', 'contract_id');
    }
}
