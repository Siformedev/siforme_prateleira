<?php

namespace App\Http\Controllers\Gerencial;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrcamentoCategoriaController extends Controller
{
    public function create()
    {
        $categorias = \App\CategoriasProdutosEServicos::all()->toArray();
        foreach ($categorias as $categoria){
            $categoriaArray[$categoria['id']] = $categoria['name'];
        }
        return view('gerencial.orcamento.categoria_create', ['categorias' => $categoriaArray]);
    }
}
