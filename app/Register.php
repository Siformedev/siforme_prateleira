<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Register extends Model
{
    protected $fillable = [
        "contract_id",
        "course",
        "name",
        "cpf",
        "email",
        "cellphone",
        "intention"
    ];
}
