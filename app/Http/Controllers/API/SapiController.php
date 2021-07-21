<?php

namespace App\Http\Controllers\API;

use App\Forming;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class SapiController extends Controller
{

    public function consultaformando($cpf, $dtnascimento, Request $request)
    {

        $formandos = Forming::where('cpf', $cpf)->where('date_nascimento', $dtnascimento)->first();

        if($formandos){

            $retorno = [
                'error' => false,
                'message' => 'Formando Localizado',
                'data' => [
                    'Id' => $formandos->id,
                    'Name' => $formandos->nome.' '.$formandos->sobrenome,
                    'Email' => $formandos->email,
                    'PhoneNumber' => $formandos->telefone_celular,
                    'Address' => $formandos->logradouro.', '.$formandos->numero.' '.$formandos->complemento.' - '.$formandos->bairro.' - '.$formandos->cidade.' - '.$formandos->estado,
                    'CPF' => $formandos->cpf,
                    'CEP' => $formandos->cep
                ]
            ];

        }else{

            $retorno = [
                'error' => true,
                'message' => 'Credencial inválida'
            ];

        }

        return $retorno;
    }

}
