<?php
$cliente = isset($_REQUEST['c']) ? $_REQUEST['c'] : 'Prezado';
//$email_destino = 'aprovacao@adaltech.com';
$email_destino = 'eduardo@adaltech.com';
/** Envia uma msg simples para o e-mail indicado -- carece de aprimoramento*/
$jsonObj = (file_get_contents('php://input'));
/*
$r = file_get_contents(
	"https://sis.easyticket.com.br/mail_gticket/index.php?smtp=smtp.gticket.com.br&senha=gticket@12&porta=587&de=nao-responda@gticket.com.br&para=".$email_destino."&assunto=".urlencode("Retorno Aut PSEG")."&nome_remetente=".urlencode("Retorno Aut PSEG")."&mensagem=".urlencode("o cliente $cliente fez a autorizacao<br> Data:".$jsonObj)
    );
	*/
?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Modelo Aplicação PSEG - Sucesso</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">
    <!-- Optional theme -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap-theme.min.css" integrity="sha384-6pzBo3FDv/PJ8r2KRkGHifhEocL+1X2rVCTTkUfGk7/0pbek5mMa1upzvWbrUbOZ" crossorigin="anonymous">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>
    <style>
        .jumbotron{
            background: #ed640a;
            color: #fff;
            font-family: 'Montserrat', sans-serif;
        }
        .lead{
            //background: rgba(255,255,255,0.65);*/
        }
        .btn{
            background-color: #18100d !important;
            color: #fff;
        }
        .img_gtk{
            padding: 10px;
        }
    </style>
</head>

<body>
    
    <div class="container">
    
        <div class="jumbotron">
		<img src="https://formatura.siforme.com.br/site/img/logo.png" class='img_gtk'>
        <h1 class="display-4"><?= $cliente ?>, obrigado por ter concluído a associação</h1>
            
            <hr class="my-4">
            <p>
            Aguarde confirmação da equipe de suporte para iniciar suas vendas.            
            </p>
                        
            </div>
        
    </div>
</body>

</html>