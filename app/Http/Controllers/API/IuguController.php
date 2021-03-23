<?php

namespace App\Http\Controllers\API;

use App\FormandoProdutosParcelas;
use App\Http\Controllers\Controller;
use App\PagamentosBoleto;
use App\PagamentosCartao;
use App\ParcelasPagamentos;
use App\Services\IuguService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class IuguController extends Controller
{

    protected $iugu;

    public function __construct()
    {
        $this->iugu = new IuguService();
    }

    public function webhook(Request $request)
    {
        $event = $request->get('event');
        $data = $request->get('data');


        $retorno = $this->iugu->consultarInvoice($data['id']);


        $txt = "
            EVENT = {$event}\n
            STATUS = {$retorno->status}\n
            ID = {$data['id']}\n
            DateTime = ".date('Y-m-d H:i:s')."\n
        ";

        $date = Carbon::now();
        Storage::put("logs/iugu/{$date->format('Ymd_Hisu')}.txt", $txt);

        if($retorno->payable_with == "bank_slip"){
            $this->baixaBoleto($retorno);
        }

        if($retorno->payable_with == "credit_card"){
            $this->baixaCartao($retorno);
        }





    }


    public function baixaBoleto($retorno){

        if($retorno->id and ($retorno->status == 'paid' or $retorno->status == 'partially_paid')){
            $dataInsert = [
                'valor_pago' => IuguService::convertCentsToCurrency($retorno->total_paid_cents),
                'payable_with' => $retorno->payable_with,
                'due_date' => $retorno->due_date,
                'total_cents' => IuguService::convertCentsToCurrency($retorno->total_cents),
                'paid_cents' => IuguService::convertCentsToCurrency($retorno->paid_cents),
                'status' => $retorno->status,
                'paid_at' => $retorno->occurrence_date,
                'secure_url' => $retorno->secure_url,
                'taxes_paid_cents' => IuguService::convertCentsToCurrency($retorno->taxes_paid_cents),
                'deleted' => 0
            ];

            $pgBoleto = PagamentosBoleto::where('invoice_id', $retorno->id);
            $pgBoleto->update($dataInsert);

            $pgBoletoGet = PagamentosBoleto::where('invoice_id', $retorno->id)->get()->first();

            $parcelaPagamento = ParcelasPagamentos::find($pgBoletoGet->parcela_pagamento_id);
            $parcelaPagamento->update(['valor_pago' => IuguService::convertCentsToCurrency($retorno->paid_cents), 'deleted' => 0]);
        }

        if($retorno->id and $retorno->status == 'canceled'){

            $pgBoleto = PagamentosBoleto::where('invoice_id', $retorno->id)->first();

            $data = [
                'status' => $retorno->status,
                'deleted' => 1,
            ];

            $deleteBoleto = $pgBoleto->update($data);
            $deleteParcelaPagamento = $pgBoleto->parcelaPagamento->update(['deleted' => 1]);

            echo $deleteBoleto;
            echo $deleteParcelaPagamento;


        }

        if($retorno->id and $retorno->status == 'expired'){

            $pgBoleto = PagamentosBoleto::where('invoice_id', $retorno->id)->first();

            $data = [
                'status' => $retorno->status,
                'deleted' => 1,
            ];

            $deleteBoleto = $pgBoleto->update($data);
            $deleteParcelaPagamento = $pgBoleto->parcelaPagamento->update(['deleted' => 1]);

            echo $deleteBoleto;
            echo $deleteParcelaPagamento;

        }
    }

    public function baixaCartao($retorno)
    {

        if($retorno->id){
            $dataInsert = [
                'items_total_cents' => IuguService::convertCentsToCurrency($retorno->items_total_cents),
                'payable_with' => $retorno->payable_with,
                'status' => $retorno->status,
                'due_date' => $retorno->due_date,
                'total' => IuguService::convertRealToDecimal($retorno->total),
                'taxes_paid' => IuguService::convertRealToDecimal($retorno->taxes_paid),
                'total_paid' => IuguService::convertRealToDecimal($retorno->total_paid),
                'total_overpaid' => IuguService::convertRealToDecimal($retorno->total_overpaid),
                'paid' => IuguService::convertRealToDecimal($retorno->paid),
                'secure_id' => $retorno->secure_id,
                'secure_url' => $retorno->secure_url,
                'installments' => $retorno->installments,
                'transaction_number' => $retorno->transaction_number,
                'payment_method' => $retorno->payment_method,
                'paid_at' => $retorno->occurrence_date,
                'deleted' => 0
            ];

            $pgCartao = PagamentosCartao::where('invoice_id', $retorno->id);
            $pgCartao->update($dataInsert);

            $pgCartaoGet = PagamentosCartao::where('invoice_id', $retorno->id)->get()->first();

            $parcelaPagamento = ParcelasPagamentos::find($pgCartaoGet->parcela_pagamento_id);
            $parcelaPagamento->update(['valor_pago' => IuguService::convertCentsToCurrency($retorno->paid_cents), 'deleted' => 0]);
        }

    }

    public function consults($date){

        $dueDateTime = Carbon::createFromFormat('Y-m-d', $date);
        $parcels = FormandoProdutosParcelas::where('dt_vencimento', $dueDateTime->format('Y-m-d'))->get();
        foreach ($parcels as $parcel){

            foreach ($parcel->pagamento as $pgs){

                if(isset($pgs->typepaind)){

                    if($pgs->typepaind->deleted == 1){
                        continue;
                    }

                    if($pgs->typepaind->status == 'paid'){
                        continue;
                    }

                    echo $pgs->typepaind->status;
                    echo "---";
                    echo $pgs->typepaind->invoice_id;
                    echo "---";


                    $retorno = $this->iugu->consultarInvoice($pgs->typepaind->invoice_id);

                    if($retorno){

                        if($retorno->payable_with == "bank_slip"){
                            $this->baixaBoleto($retorno);

                            echo $retorno->status;
                        }

                    }
                    echo "<br>";

                }

            }

        }

    }

}
