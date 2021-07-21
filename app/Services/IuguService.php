<?php
/**
 * Created by PhpStorm.
 * User: leonardozaneladias
 * Date: 17/05/17
 * Time: 17:11
 */

namespace App\Services;

use GuzzleHttp\Client;
use Iugu;
use Iugu_Charge;

class IuguService
{

    private $client;

    public function __construct()
    {
        $this->client = new Client([
            'headers' => ['Authorization' => ' Basic '.base64_encode(env('IUGU_KEY').':'), 'Accept' => 'application/json']
        ]);
    }

    public function criarBoleto($data){

        /*EXEMPLO DE DATA
		[
			'email' => 'leonardozaneladias@gmail.com',
			'due_date' => '2018-02-28',
			"items[]" => [
					"description"=>"Item Teste",
					"quantity"=>"1",
					"price_cents"=>"3900"
			],
			"payer" => [
				"cpf_cnpj"=>"33044918804",
				"name"=>"Leonardo Zanela Dias",
				"address"=>[
					'zip_code' => '03908000',
					'number' => '99'
				]
			],
			"payable_with" => "bank_slip"
		]
		*/

        try {
            $response = $this->client->post('https://api.iugu.com/v1/invoices', [
                'form_params' => $data
            ]);
            return \GuzzleHttp\json_decode($response->getBody()->getContents());
        }catch (\Exception $exception) {
            ($exception->getMessage());
            //$response = json_decode($e->getResponse());
            //return $response;
        }
    }

    public function pagarCartao($data){

        /*EXEMPLO DE DATA
		[
			'email' => 'leonardozaneladias@gmail.com',
			'token' => '05CCF6F5-4499-4B77-819F-06BB83365F88',
			"items[]" => [
					"description"=>"Item Teste",
					"quantity"=>"1",
					"price_cents"=>"3900"
			],
			"months" => "1"
		]
		*/



        try {
            $response = $this->client->post('https://api.iugu.com/v1/charge', [
                'form_params' => $data
            ]);
            return \GuzzleHttp\json_decode($response->getBody()->getContents());
            //dd("ok", $data);
        }catch (\Exception $exception) {
            dump($exception->getMessage());
        }
    }

    public function IuguCredit($data){
        Iugu::setApiKey(env('IUGU_KEY')); // Ache sua chave API no Painel

        try {
            $response = Iugu_Charge::create($data);
            return $response;
        }catch (\Exception $exception) {
            return $exception->getMessage();
        }
    }

    public function consultarInvoice($id){

        try {
            $response = $this->client->get('https://api.iugu.com/v1/invoices/'.$id);
            return \GuzzleHttp\json_decode($response->getBody()->getContents());
        }catch (\Exception $exception) {
            ($exception);
            //$response = json_decode($e->getResponse());
            //return $response;
        }
    }

    public function cancelarInvoice($id){

        try {
            $response = $this->client->put('https://api.iugu.com/v1/invoices/'.$id.'/cancel');
            return \GuzzleHttp\json_decode($response->getBody()->getContents());
        }catch (\Exception $exception) {
            ($exception);
            //$response = json_decode($e->getResponse());
            //return $response;
        }
    }

    public static function convertCentsToCurrency($data){
        if($data <= 0){return 0;}
        $len = strlen($data);
        return substr($data, 0, $len-2).'.'.substr($data, -2);
    }

    public static function convertRealToDecimal($data){
        $data = str_replace("R$", "", $data);
        $data = str_replace(".", "", $data);
        $data = str_replace(",", ".", $data);
        $data = trim($data);
        $data = number_format($data, 2, ".", "");
        return $data;

    }

}