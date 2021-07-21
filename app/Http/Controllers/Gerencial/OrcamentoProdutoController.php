<?php

namespace App\Http\Controllers\Gerencial;

use App\CategoriasProdutosEServicos;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrcamentoProdutoController extends Controller
{
    public function create()
    {
        $categorias = \App\CategoriasProdutosEServicos::all()->toArray();
        foreach ($categorias as $categoria){
            $categoriaArray[$categoria['id']] = $categoria['name'];
        }
        return view('gerencial.orcamento.produto', ['categorias' => $categoriaArray]);
    }
}
