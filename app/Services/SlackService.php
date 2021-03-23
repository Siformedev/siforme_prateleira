<?php
/**
 * Created by PhpStorm.
 * User: leonardozaneladias
 * Date: 17/05/17
 * Time: 17:11
 */

namespace App\Services;


use GuzzleHttp\Client;

class SlackService
{

    private $client;
    private $channel;

    public function __construct($channel)
    {
        $this->client = new Client([
            'headers' => ['Content-type' => 'application/json']
        ]);
        $this->channel = $channel;
    }

    public function SendNotification($msg){

        $json = ['text' => $msg];

        try {
            $response = $this->client->post($this->channel, [
                'body' => json_encode($json)
            ]);
//            return \GuzzleHttp\json_decode($response->getBody()->getContents());
            \GuzzleHttp\json_decode($response->getBody()->getContents());

        }catch (\Exception $exception) {

           return true;

        }
    }

}