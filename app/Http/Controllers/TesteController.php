<?php

namespace App\Http\Controllers;

use App\Forming;
use App\Helpers\CropAvatar;
use Illuminate\Http\Request;

use App\Http\Requests;

class TesteController extends Controller
{
    public function t1(){
        $teste = new \App\Services\CieloCheckoutService();
        echo $teste->criarPagamento("OKOK");
    }

    public function testSlack()
    {
        $slack = new \App\Services\SlackService('https://hooks.slack.com/services/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');
        $slack->SendNotification('teste 2 OKOKOK!');
    }
}
