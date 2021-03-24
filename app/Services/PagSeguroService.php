<?php

/**
 * Created by PhpStorm.
 * User: leonardozaneladias
 * Date: 17/05/17
 * Time: 17:11
 */

namespace App\Services;

use App\AccountPseg;
use App\Contract;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PagSeguroService
{

    private $client;
    //    private $email = 'leoztech8@gmail.com';
    private $email;
    //    private $token = '78554de0-4e93-423e-bbcf-eeba5a930b117e5c6b974509b8ce3c660c82bd5668bc3da7-62e5-4ea8-a9db-8a8b51a665d8';
    private $token;

    /** Modelo de aplicação PASSAR para o env depois*/
    private $app_id;
    /** ID da aplicacao */
    private $key_pseg;
    private $auth_pseg;
    private $id_sesssao;
    private $contrato_id;
    /**authorizationCode da conta adalbertoandreoli@gmail.com    */

    public function __construct($contrato_id = null)
    {
        $this->$contrato_id = $contrato_id;

        if (!empty($this->$contrato_id)) {
            //dd($this->$acc);
            $contrato = Contract::where('id', $contrato_id)->get()->toArray()[0];
            //dd($contrato);
        } else {
            $contrato = @Contract::where('id', @Auth::user()->userable->contract_id)->get()->toArray()[0];
        }

        $acc_pseg = @AccountPseg::find($contrato['pseg_acc']);

        $this->token = @$acc_pseg->pseg_token;
        $this->email = @$acc_pseg->pseg_email;
        $this->auth_pseg = @$acc_pseg->app_pseg_auth;
        $this->app_id = @$acc_pseg->app_pseg_id;
        $this->key_pseg = @$acc_pseg->app_pseg_key;
        //$this->app_id = env('APP_PSEG_ID');
        //$this->key_pseg = env('APP_PSEG_KEY');
        //$this->auth_pseg = env('APP_PSEG_AUTH');
        //$this->email = env('PSEG_EMAIL');
        //$this->token = env('PSEG_TOKEN');

        $this->client = new Client([
            //'headers' => ['Authorization' => 'Bearer '.$this->token],
            //'Content-Type' => 'application/json'
        ]);

        //$this->id_sesssao = $this->geraSessao();
    }

    public function geraSessao()
    {

        try {
            // $response = $this->client->post("https://ws.pagseguro.uol.com.br/v2/sessions?email={$this->email}&token={$this->token}", []);
            $response = $this->client->post("https://ws.pagseguro.uol.com.br/v2/sessions?email=granmuranocg@gmail.com&token=bc15021f-ebc7-4c39-bb41-6fd1a00e97ee6d747d1447f7a8e9569310513b4d91c54ff8-a894-48b9-af2a-4eeb84c6be4c", []);

            return simplexml_load_string($response->getBody()->getContents())->id;
        } catch (\Exception $exception) {
            Log::debug('erro pagseguroservice:55: ' . json_encode($exception->getMessage()));
            return array('sucesso' => false, 'message' => $exception->getMessage());
        }
    }

    public function criarCartao($data)
    {

        try {
            $response = $this->client->post("https://ws.pagseguro.uol.com.br/v2/transactions?appId={$this->app_id}&appKey={$this->key_pseg}&authorizationCode=$this->auth_pseg", [
                'form_params' => $data,
            ]);

            $response_obj = simplexml_load_string($response->getBody()->getContents());
            Log::debug('TRN com CC: ' . json_encode($response_obj));
            return $response_obj;
        } catch (\Exception $exception) {
            Log::debug('erro pagseguroservice:68: ' . json_encode($exception->getMessage()));
            return array('sucesso' => false, 'message' => $exception->getMessage());
        }

    }

    public function criarBoleto($data)
    {
        try {

            $response = $this->client->post("https://ws.pagseguro.uol.com.br/v2/transactions?appId={$this->app_id}&appKey={$this->key_pseg}&authorizationCode=$this->auth_pseg", [
                'form_params' => $data,
            ]);

            $response_obj = simplexml_load_string($response->getBody()->getContents());

            Log::debug('TRN com boleto: ' . json_encode($response_obj));

            return $response_obj;

        } catch (\Exception $exception) {
            Log::debug('erro pagseguroservice:114: ' . json_encode($exception->getMessage()));
            Log::debug('erro pagseguroservice:115: ' . json_encode($data));
            return $exception->getMessage();
        }
    }

    public function consultarTransacao($notificationCode, $contrato_id = null)
    {
        if (!empty($contrato_id)) {
            self::__construct($contrato_id); 
        }

        try {
            // $response = $this->client->get("https://ws.pagseguro.uol.com.br/v3/transactions/notifications/{$notificationCode}?email={$this->email}&token={$this->token}", []);
            $response = $this->client->get("https://ws.pagseguro.uol.com.br/v3/transactions/".$notificationCode."?email=granmuranocg@gmail.com&token=bc15021f-ebc7-4c39-bb41-6fd1a00e97ee6d747d1447f7a8e9569310513b4d91c54ff8-a894-48b9-af2a-4eeb84c6be4c", []);


            $xml_string = $response->getBody()->getContents();
            $response = simplexml_load_string($xml_string);

        } catch (\Exception $exception) {
            Log::debug('erro pagseguroservice:130: ' . json_encode(($exception->getMessage())));
            $response = $exception->getMessage();

        }
        return $response;
    }

    public static function convertCentsToCurrency($data)
    {
        if ($data <= 0) {
            return 0;
        }
        $len = strlen($data);
        return substr($data, 0, $len - 2) . '.' . substr($data, -2);
    }

    public static function convertRealToDecimal($data)
    {
        $data = str_replace("R$", "", $data);
        $data = str_replace(".", "", $data);
        $data = str_replace(",", ".", $data);
        $data = trim($data);
        $data = number_format($data, 2, ".", "");
        return $data;
    }

    public function cod_status($cod)
    {

        switch ($cod) {
            case 1:
                $status = 'Pendente';
                break;
            case 2:
                $status = 'Pendente';
                break;
            case 3:
                $status = 'Pago';
                break;
            case 4:
                $status = 'Pago';
                break;
            case 7:
                $status = 'Recusado';
                break;
            case 6:
                $status = 'Devolvida';
                break;
        }
        return $status;
    }

    public function tipo_pagamento($cod)
    {
        switch ($cod) {
            case 1:
                $tipo = 'CARTAO_CREDITO';
                break;
            case 2:
                $tipo = 'BOLETO';
                break;
            case 3:
                $tipo = 'DEBITO_ONLINE';
                break;
            case 4:
                $tipo = 'CONTA_PSEG';
                break;
            case 7:
                $tipo = 'DEPOSITO_CONTA';
                break;
        }
        return $tipo;
    }

    public function error_list($code)
    {

        $list = [
            53081 => "O comprador e o vendedor são a mesma pessoa",
            10003 => "Valor inválido por email.",
            10005 => "As contas do fornecedor e do comprador não podem ser relacionadas entre si.",
            10009 => "Método de pagamento indisponível no momento.",
            10020 => "Forma de pagamento inválida.",
            10021 => "Erro ao buscar dados do fornecedor do sistema.",
            10023 => "Forma de pagamento indisponível.",
            10024 => "Comprador não registrado não é permitido.",
            10025 => "senderName não pode ficar em branco.",
            10026 => "senderEmail não pode ficar em branco.",
            10049 => "senderName obrigatório.",
            10050 => "senderEmail obrigatório.",
            11002 => "comprimento inválido do receptorEmail: {0}",
            11006 => "comprimento inválido de redirectURL: {0}",
            11007 => "valor inválido de redirectURL: {0}",
            11008 => "referência comprimento inválido: {0}",
            11013 => "valor inválido senderAreaCode: {0}",
            11014 => "valor inválido senderPhone: {0}",
            11027 => "Quantidade de itens fora do intervalo: {0}",
            11028 => "A quantidade do item é necessária. (por exemplo, '12,00')",
            11040 => "maxAge padrão inválido: {0}. Deve ser um número inteiro.",
            11041 => "maxAge fora do intervalo: {0}",
            11042 => "maxUtiliza padrão inválido: {0}. Deve ser um número inteiro.",
            11043 => "maxUses fora do intervalo: {0}",
            11054 => "abandonURLL / reviewURL comprimento inválido: {0}",
            11055 => "valor inválido abandonURL / reviewURL: {0}",
            11071 => "valor inválido preApprovalInitialDate.",
            11072 => "valor inválido preApprovalFinalDate.",
            11084 => "o vendedor não tem opção de pagamento com cartão de crédito.",
            11101 => "são necessários dados de pré-aprovação.",
            11163 => "Você deve configurar um URL de notificação de transações (Notificação de Transações) antes de usar este serviço.",
            11211 => "a pré-aprovação não pode ser paga duas vezes no mesmo dia.",
            13005 => "initialDate deve ser menor que o limite permitido.",
            13006 => "initialDate não deve ter mais de 180 dias.",
            13007 => "initialDate deve ser menor ou igual a finalDate.",
            13008 => "o intervalo de pesquisa deve ser menor ou igual a 30 dias.",
            13009 => "finalDate deve ser menor que o limite permitido.",
            13010 => "formato inválido initialDate use 'aaaa-MM-ddTHH: mm' (por exemplo, 2010-01-27T17: 25).",
            13011 => "formato inválido finalDate use 'aaaa-MM-ddTHH: mm' (por exemplo, 2010-01-27T17: 25).",
            13013 => "valor inválido da página.",
            13014 => "valor inválido de maxPageResults (deve estar entre 1 e 1000).",
            13017 => "initialDate e finalDate são necessários na procura por intervalo.",
            13018 => "o intervalo deve estar entre 1 e 30.",
            13019 => "é necessário um intervalo de notificação.",
            13020 => "página é maior que o número total de páginas retornadas.",
            13023 => "Comprimento de referência mínimo inválido (1-255)",
            13024 => "Comprimento máximo de referência inválido (1-255)",
            17008 => "pré-aprovação não encontrada.",
            17022 => "status de pré-aprovação inválido para executar a operação solicitada. O status de pré-aprovação é {0}.",
            17023 => "o vendedor não tem opção de pagamento com cartão de crédito.",
            17024 => "a pré-aprovação não é permitida para este vendedor {0}",
            17032 => "destinatário inválido para checkout: {0} verifique o status da conta do destinatário e se é uma conta do vendedor.",
            17033 => "preApproval.paymentMethod não é {0} deve ser o mesmo da pré-aprovação.",
            17035 => "O formato de vencimento é inválido: {0}.",
            17036 => "O valor do prazo de vencimento é inválido: {0}. Qualquer valor de 1 a 120 é permitido.",
            17037 => "Os dias de vencimento devem ser menores que os dias de vencimento.",
            17038 => "O formato dos dias de expiração é inválido: {0}.",
            17039 => "O valor da expiração é inválido: {0}. Qualquer valor de 1 a 120 é permitido.",
            17061 => "Plano não encontrado.",
            17063 => "Hash é obrigatório.",
            17065 => "Documentos necessários.",
            17066 => "Quantidade de documento inválida.",
            17067 => "O tipo de método de pagamento é obrigatório.",
            17068 => "O tipo de método de pagamento é inválido.",
            17069 => "O telefone é obrigatório.",
            17070 => "Endereço é obrigatório.",
            17071 => "Remetente é obrigatório.",
            17072 => "O método de pagamento é obrigatório.",
            17073 => "Cartão de crédito é obrigatório.",
            17074 => "O titular do cartão de crédito é obrigatório.",
            17075 => "O token do cartão de crédito é inválido.",
            17078 => "Data de vencimento atingida.",
            17079 => "Limite de uso excedido.",
            17080 => "A pré-aprovação está suspensa.",
            17081 => "ordem de pagamento de pré-aprovação não encontrada.",
            17082 => "status inválido da ordem de pagamento de pré-aprovação para executar a operação solicitada. O status do pedido de pagamento com pré-aprovação é {0}.",
            17083 => "A pré-aprovação já é {0}.",
            17093 => "É necessário o hash do remetente ou o IP.",
            17094 => "Não pode haver novas assinaturas para um plano inativo.",
            19001 => "postalCode inválido Valor: {0}",
            19002 => "endereço Comprimento inválido da rua: {0}",
            19003 => "endereçoNúmero comprimento inválido: {0}",
            19004 => "endereçoComplemento de comprimento inválido: {0}",
            19005 => "comprimento inválido addressDistrict: {0}",
            19006 => "comprimento inválido addressCity: {0}",
            19007 => "valor inválido addressState: {0} deve se ajustar ao padrão: \ w {2} (por exemplo, 'SP')",
            19008 => "comprimento inválido addressCountry: {0}",
            19014 => "valor inválido senderPhone: {0}",
            19015 => "padrão inválido addressCountry: {0}",
            50103 => "o código postal não pode estar vazio",
            50105 => "o número do endereço não pode estar vazio",
            50106 => "endereço do distrito não pode estar vazio",
            50107 => "o país do endereço não pode estar vazio",
            50108 => "endereço da cidade não pode estar vazio",
            50131 => "O endereço IP não segue um padrão válido",
            50134 => "endereço rua não pode estar vazia",
            53037 => "é necessário um token de cartão de crédito.",
            53042 => "o nome do titular do cartão de crédito é obrigatório.",
            53047 => "é necessária a data de nascimento do titular do cartão de crédito.",
            53048 => "valor inválido da data de nascimento do titular do cartão de crédito: {0}",
            53151 => "O valor do desconto não pode ficar em branco.",
            53152 => "Valor do desconto fora do intervalo. Para o tipo DISCOUNT_PERCENT, o valor deve ser maior ou igual a 0,00 e menor ou igual a 100,00.",
            53153 => "não encontrado no próximo pagamento para esta pré-aprovação.",
            53154 => "O status não pode ficar em branco.",
            53155 => "O tipo de desconto é obrigatório.",
            53156 => "Valor inválido do tipo de desconto. Os valores válidos são: DISCOUNT_AMOUNT e DISCOUNT_PERCENT.",
            53157 => "Valor do desconto fora da faixa. Para o tipo DISCOUNT_AMOUNT, o valor deve ser maior ou igual a 0,00 e menor ou igual ao valor máximo do pagamento correspondente.",
            53158 => "O valor do desconto é obrigatório.",
            57038 => "endereço do estado é necessário.",
            61007 => "tipo de documento é necessário.",
            61008 => "o tipo de documento é inválido: {0}",
            61009 => "o valor do documento é necessário.",
            61010 => "o valor do documento é inválido: {0}",
            61011 => "cpf é inválido: {0}",
            61012 => "cnpj é inválido: {0}",
        ];
        
        if( isset($list[$code]) ){
            return $list[$code];
        }else{
            return ("Erro ao tentar emitir boleto, favor entre em contato com nosso atendimento contato@arrecadeei.com.br");
        }


    }
}
