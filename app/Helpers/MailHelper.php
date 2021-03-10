<?php

namespace App\Helpers;


class Mail
{

    public function sendMail($assunto,$msg,$email,$nomeRemetente=null,$cc=null){

        $x_auth_token = ' 21f6b750133d4af17f9fa7a1612cfdf0';
        $api_url = 'https://api.smtplw.com.br/v1';

        $from = "site@agenciapni.com.br";
        $to = array($email);
        $subject = $assunto;
        $body = $msg;

        $headers = array(
            "x-auth-token: $x_auth_token",
            "Content-type: application/json"
        );

        $data_string = array(
            'from'    => $from,
            'to'      => $to,
            'subject' => $subject,
            'body'    => $body,
            'headers' => array('Content-type' => 'text/html')
        );

        $ch = curl_init("$api_url/messages");

        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data_string));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        $response = curl_exec($ch);
        $curlInfo = curl_getinfo($ch);
        curl_close($ch);

        switch($curlInfo['http_code']) {
            case '201':
                $status = 'OK';
                if (preg_match('@^Location: (.*)$@m', $response, $matches)) {
                    $location = trim($matches[1]);
                }
                // Add other actions here, if necessary.
                break;
            default:
                $status = "Error: $curlInfo[http_code]";
                break;
        }

        return $status;

    }

}