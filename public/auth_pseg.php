<?php
/** Se foi enviado o parâmetro 'c' esse valor será usado para preencher uma mensagem dinâmica com o nome do cliente.*/
$cliente = isset($_REQUEST['c']) ? $_REQUEST['c'] : 'Prezado';

/** mensagem que será enviada junto com a tentativa de ctto com o comercial*/
$msg_whats = urlencode('Estou na página de autorização do PAGSEGURO e gostaria de falar sobre:');
$num_whats_comercial = '';

/** Toma a url atual, remove o último slug para gerar uma url de retorno dinâmica*/
$url = explode('/', "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
array_pop($url);
$url_retorno = implode('/', $url) . '/retorno_auth_pseg.php?c='.$cliente;

/** ID e KEY da aplicação no PAGSEGURO*/
/** Id da aplicação é o nome que foi dado para a mesma, esta em um input chamado 'ID da aplicação:'*/
$keys[0]['appId'] = 'siforme';
/** A chave da aplicação esta oculto após a criação, pode-se fazer uma renovação para pegar a atual*/
// Troquei a chaves pois parou de funcionar em 19/12/2020
// $keys[0]['appKey'] = '601DC6150606FEA334101F89F66E74F2';
$keys[0]['appKey'] = '7FFA349F35351DEBB4D41FBDE3E5DCBA';

$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => "https://ws.pagseguro.uol.com.br/v2/authorizations/request/?appId=".$keys[0]['appId']."&appKey=".$keys[0]['appKey'],
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => "<?xml version=\"1.0\" encoding=\"UTF-8\" standalone=\"yes\"?>\r\n<authorizationRequest>\r\n    <reference>REF1234</reference>\r\n    <permissions>\r\n        <code>CREATE_CHECKOUTS</code>\r\n        <code>RECEIVE_TRANSACTION_NOTIFICATIONS</code>\r\n        <code>SEARCH_TRANSACTIONS</code>\r\n        <code>MANAGE_PAYMENT_PRE_APPROVALS</code>\r\n        <code>DIRECT_PAYMENT</code>\r\n    </permissions>\r\n<redirectURL>$url_retorno</redirectURL>\r\n</authorizationRequest>",
    CURLOPT_HTTPHEADER => array(
        "Accept: */*",
        "Content-Type: application/xml; charset=ISO-8859-1",
    ),
));

curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
	/** Se ocorrer um erro ele será exibido encodado em base64 para o cliente, assim que mais friendly uma eventual identificação de erro*/
    $err = base64_encode($err);
}

$xml = simplexml_load_string($response, "SimpleXMLElement", LIBXML_NOCDATA);
$json = json_encode($xml);
$retorno_pseg = json_decode($json, TRUE);
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Modelo Aplicação PSEG</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">
    <!-- Optional theme -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap-theme.min.css" integrity="sha384-6pzBo3FDv/PJ8r2KRkGHifhEocL+1X2rVCTTkUfGk7/0pbek5mMa1upzvWbrUbOZ" crossorigin="anonymous">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>
    <style>
        .jumbotron {
            background: #ed640a;
            color: #fff;
            font-family: 'Montserrat', sans-serif;
        }

        .lead {
            //background: rgba(255,255,255,0.65);*/
        }

        .btn {
            background-color: #18100d !important;
            color: #fff;
        }

        .img_gtk {
            padding: 10px;
        }
    </style>
</head>

<body>
    <div class="container">
        
        <div class="jumbotron">
		<img src="https://formatura.siforme.com.br/site/img/logo.png" class='img_gtk'>
            <h1 class="display-4">Olá <?= $cliente ?></h1>
            <p class="lead">
                <?php echo ($err) ? "Ocorreu um erro ao processar seu pedido, por favor devolva o código abaixo para quem lhe enviou esse link:<br>" : "Ao clicar no botão abaixo você será redirecionado para o ambiente do PAGSEGURO para vincular sua conta ao perfil do Siforme." ?>
            </p>
            <hr class="my-4">
            <p>
                <?php echo ($err) ? $err : "Esta é uma configuração que pode garantir vantagens* nas tarifas cobradas pelo PAGSEGURO." ?>
            </p>
            <?php if (!($err)) : ?>
                <a class="btn pull-right" href="https://pagseguro.uol.com.br/v2/authorization/request.jhtml?code=<?= $retorno_pseg['code'] ?>" role="button"><strong>Conceder Autorização</strong></a>
            <?php endif; ?>
            <br>
        </div>
        <small>* Conforme negociação realizada com o <a target='_blank' href='https://wa.me/<?=$num_whats_comercial?>?text=<?= $msg_whats ?>'>Comercial</a> </small>
    </div>
</body>
</html>