<?php
/**
 * Created by PhpStorm.
 * User: leonardozaneladias
 * Date: 17/05/17
 * Time: 14:28
 */

namespace App\Services;


use App\Contract;
use App\Forming;

class FormandoServices
{

    public function cadastraFormando($dadosFormando, $dadosContrato)
    {

        //Tratamento pré insert
        $dadosTratados['contract_id'] = Contract::where('code', $dadosContrato['code'])->where('valid', $dadosContrato['valid'])->select('id')->get()->toArray()[0]['id'];
        $dadosTratados['nome'] = title_case(trim($dadosFormando['nome']));
        $dadosTratados['sobrenome'] = title_case(trim($dadosFormando['sobrenome']));
        $dadosTratados['cpf'] = str_replace(".","", str_replace("-", "", $dadosFormando['cpf']));
        $dadosTratados['rg'] = $dadosFormando['rg'];
        $dadosTratados['date_nascimento'] = \DateTime::createFromFormat('d/m/Y', $dadosFormando['datanascimento'])->format('Y-m-d');
        $dadosTratados['sexo'] = $dadosFormando['sexo'];
        $dadosTratados['cep'] = str_replace("-","", str_replace(" ", "", $dadosFormando['cep']));
        $dadosTratados['logradouro'] = title_case(trim($dadosFormando['logradouro']));
        $dadosTratados['numero'] = title_case(trim($dadosFormando['numero']));
        $dadosTratados['complemento'] = title_case(trim($dadosFormando['complemento']));
        $dadosTratados['bairro'] = title_case(trim($dadosFormando['bairro']));
        $dadosTratados['cidade'] = title_case(trim($dadosFormando['cidade']));
        $dadosTratados['estado'] = strtoupper(trim($dadosFormando['estado']));
        $dadosTratados['email'] = strtolower(trim($dadosFormando['email']));
        $dadosTratados['telefone_residencial'] = $dadosFormando['telefone-residencial'];
        $dadosTratados['telefone_celular'] = $dadosFormando['telefone-celular'];
        $dadosTratados['nome_do_pai'] = $dadosFormando['nome_do_pai'];
        $dadosTratados['telefone_celular_pai'] = $dadosFormando['telefone_celular_pai'];
        $dadosTratados['email_do_pai'] = $dadosFormando['email_do_pai'];
        $dadosTratados['nome_da_mae'] = $dadosFormando['nome_da_mae'];
        $dadosTratados['email_da_mae'] = $dadosFormando['email_da_mae'];
        $dadosTratados['telefone_celular_mae'] = $dadosFormando['telefone_celular_mae'];
        $dadosTratados['altura'] = floatval(str_replace("'", "", $dadosFormando['altura']));
        $dadosTratados['camiseta'] = $dadosFormando['camiseta'];
        $dadosTratados['calcado'] = $dadosFormando['calcado'];
        $dadosTratados['curso_id'] = $dadosFormando['course'];
        $dadosTratados['periodo_id'] = $dadosFormando['periodo'];
        $dadosTratados['dt_adesao'] = date('Y-m-d H:i:s');
        $dadosTratados['status'] = 1;
        $dadosTratados['valid'] = uniqid(str_random(32));

        //dd($dadosTratados);

        try{
            $formando = new Forming;
            $formando = $formando->create($dadosTratados);
            return $formando;
        }catch (\Exception $exceptionx){
            echo $exceptionx->getMessage();
        }

    }

}