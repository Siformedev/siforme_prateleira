<?php
/**
 * Created by PhpStorm.
 * User: leonardozaneladias
 * Date: 17/05/17
 * Time: 17:11
 */

namespace App\Services;


use GuzzleHttp\Client;

class CieloCheckoutService
{

    private $client;

    public function __construct()
    {
        $this->client = new Client([
            'Accept' => 'application/json',
            'headers' => ['MerchantId' => env('CIELO_CHECKOUT_MERCHANT_ID')]
        ]);
    }

    public function criarPagamento(){

        $json = [];
        $json['OrderNumber'] = "";
        $json['SoftDescriptor'] = "AGENCIAPNI";
        $json['Cart'] = [
            'Discount' => [
                'Type' => 'Percent',
                'Value' => 0
            ],
            "Items" => [[
                "Name" => "Compras Extras PNI",
                "Description" => "Compras de Convites e/ou Mesas Extras PNI",
                "UnitPrice" => number_format(400,2, '', ''),
                "Quantity" => 1,
                "Type" => "Payment",
                "Sku" => "",
                "Weight" => 0,
            ]]
        ];
        $json['Shipping'] = [
            'SourceZipCode' => "09530001",
            'TargetZipCode' => "09530001",
            'Type' => "WithoutShipping"
        ];
        $json['Payment'] = [
            'BoletoDiscount' => 0,
            'DebitDiscount' => 0,
            'Installments' => "null",
            'MaxNumberOfInstallments' => 7
        ];
        $json['Customer'] = [
            'Identity' => '40486390802',
            'FullName' => "Nome Completo",
            'Email' => "leonardo@agenciapni.com.br",
            'Phone' => str_pad('11 984909936', 11, "0", STR_PAD_LEFT)
        ];
        $json['Options'] = [
            'AntifraudEnabled' => false,
            'ReturnUrl' => env("APP_URL")."/adesao/concluido"
        ];
        $json['Settings'] = null;

        try {

            $response = $this->client->post('https://cieloecommerce.cielo.com.br/api/public/v1/orders', [
                //'form_params' => json_encode($json)
            ]);
//            return \GuzzleHttp\json_decode($response->getBody()->getContents());
            dd(\GuzzleHttp\json_decode($response->getBody()->getContents()));

        }catch (\Exception $exception) {

           dd($exception->getCode());

        }
    }

}