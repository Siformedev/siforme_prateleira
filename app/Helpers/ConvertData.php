<?php

namespace App\Helpers;


use Carbon\Carbon;

class ConvertData
{

    public static function mes($mes)
    {
        switch ($mes){
            case 1:
                return 'JANEIRO';
                break;
            case 2:
                return 'FEVEREIRO';
                break;
            case 3:
                return 'MARÇO';
                break;
            case 4:
                return 'ABRIL';
                break;
            case 5:
                return 'MAIO';
                break;
            case 6:
                return 'JUNHO';
                break;
            case 7:
                return 'JULHO';
                break;
            case 8:
                return 'AGOSTO';
                break;
            case 9:
                return 'SETEMBRO';
                break;
            case 10:
                return 'OUTRUBRO';
                break;
            case 11:
                return 'NOVEMBRO';
                break;
            case 12:
                return 'DEZEMBRO';
                break;
            default:
                return false;
        }
    }

    public static function calculaParcelasMeses($date, $maxParcelas)
    {
        $retorno = [];
        $vencimemntos = [10, 20, 30];
        $dia_processa_boleto = 5;
        $dt = Carbon::parse($date);
        $dtInicio = Carbon::createFromDate($dt->year, $dt->month, 1);
        $now = Carbon::now();
        foreach ($vencimemntos as $vencimemnto){
            $dtForCompare = Carbon::createFromDate($now->year, $now->month, $vencimemnto);
            $dtFor = Carbon::createFromDate($now->year, $now->month, $vencimemnto);
            $inc = $dtInicio->diffInMonths($now);
            $dtForCompare = Carbon::parse($dtForCompare)->subDays($dia_processa_boleto);
            $parcela = $maxParcelas - $inc;

            if($dtForCompare <= $now) {
                $i = 1;
                $ptemp = $parcela-$i;
                $ptemp = ($ptemp <= 0 ? 1 : $ptemp);
                $dt2 = Carbon::parse($dtFor)->addMonth($i);
                $retorno[$now->diffInDays($dt2)] = ['priPagamento' => date("Y-m-d", $dt2->timestamp), 'parcelas' => $ptemp];
            }else{
                $retorno[$now->diffInDays($dtFor)] = ['priPagamento' => date("Y-m-d", $dtFor->timestamp), 'parcelas' => $parcela];
            }
        }
        asort($retorno);
        return $retorno;
    }

    public static function geraProximosParcelas()
    {
        $retorno = [];
        $vencimemntos = [10, 20, 30];
        $dia_processa_boleto = 5;
        $now = Carbon::now();
        foreach ($vencimemntos as $v){
            $dtForCompare = Carbon::createFromDate($now->year, $now->month, $v);
            $dtFor = Carbon::createFromDate($now->year, $now->month, $v);
            $dtForCompare = Carbon::parse($dtForCompare)->subDays($dia_processa_boleto);
            if($dtForCompare <= $now) {
                $i = 1;
                $dt2 = Carbon::parse($dtFor)->addMonth($i);
                $retorno[$now->diffInDays($dt2)] = ['priPagamento' => date("Y-m-d", $dt2->timestamp), 'dia' => $v];
            }else{
                $retorno[$now->diffInDays($dtFor)] = ['priPagamento' => date("Y-m-d", $dtFor->timestamp), 'dia' => $v];
            }
        }
        rsort($retorno);
        return $retorno;
    }

    public static function geraParcelasProdutos($date, $maxParcelas, $data_pagamento)
    {
        $vencimemntos = [$data_pagamento];
        $dia_processa_boleto = 0;
        $dt = Carbon::parse($date);
        $dtInicio = Carbon::createFromDate($dt->year, $dt->month, 1);
        $now = Carbon::now();
        foreach ($vencimemntos as $vencimemnto){
            $dtForCompare = Carbon::createFromDate($now->year, $now->month, $vencimemnto);
            $dtFor = Carbon::createFromDate($now->year, $now->month, $vencimemnto);
            $inc = $dtInicio->diffInMonths($now);
            $dtForCompare = Carbon::parse($dtForCompare)->subDays($dia_processa_boleto);
            $parcela = $maxParcelas - $inc;
            if($dtForCompare <= $now) {
                $i = 1;
                $dt2 = Carbon::parse($dtFor)->addMonth($i);
                $retorno= $parcela-$i;
            }else{
                $retorno = $parcela;
            }
        }
        $retorno = ($retorno <= 0) ? 1 : $retorno;
        return $retorno;
    }

}
