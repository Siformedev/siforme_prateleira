<?php

namespace App\Http\Controllers\API;

use App\FormandoProdutosParcelas;
use App\Http\Controllers\Controller;
use App\PagamentosBoleto;
use App\PagamentosCartao;
use App\ParcelasPagamentos;
use App\Services\PagSeguroService;
use DateTime;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PsegController extends Controller
{
    private $client;
    public function __construct()
    {
        $this->client = new Client([
            //'headers' => ['Authorization' => 'Bearer '.$this->token],
            //'Content-Type' => 'application/json'
        ]);
    }

    public function webhook(Request $request, PagSeguroService $pseg)
    {
        $notificationCode = $request->get('notificationCode');
        $contrato_id = $request->get('contrato');

        $transaction = $pseg->consultarTransacao($notificationCode,$contrato_id);
        //dd($transaction);

        if( isset($transaction->reference) ){
            $parcela = FormandoProdutosParcelas::find($transaction->reference);
        }else{
            return response()->json(['erro' => 'trn nao encontrada'], 555);
        }        

        if (!isset($parcela)) {
            return response('pagamento não entrando', 404);
        }

        Log::debug('Transacion pseg webhook: ' . json_encode($transaction));
        if (isset($transaction->status)) {
            $status_trn = $pseg->cod_status($transaction->status);
            $tipo_pagamento = $pseg->tipo_pagamento($transaction->paymentMethod->type);
            $date = new DateTime($transaction->date);
            $paid_at = new DateTime($transaction->lastEventDate);
        } else {
            return response()->json(['erro' => 'trn nao encontrada'], 555);
        }

        //$status_trn = 'Pago';
        if ($status_trn == 'Recusado') {

            $parcela->update(['status' => 0]);
            $pagamento = ParcelasPagamentos::where('parcela_id', $parcela->id)->first();

            if (!$pagamento) {
                $pagamento = ParcelasPagamentos::create(['parcela_id' => $parcela->id, 'valor_pago' => $transaction->grossAmount]);
            } else {
                $pagamento->update(['valor_pago' => 0, 'deleted' => 1]);
            }

            if ($tipo_pagamento == "BOLETO") {
                $pgBoleto = PagamentosBoleto::where('parcela_pagamento_id', $pagamento->id)->first();

                $data = [
                    'status' => $status_trn,
                    'deleted' => 1,
                ];

                $deleteBoleto = $pgBoleto->update($data);
                $deleteParcelaPagamento = $pgBoleto->parcelaPagamento->update(['deleted' => 1]);

                echo $deleteBoleto;
                echo $deleteParcelaPagamento;
            } elseif ($tipo_pagamento == 'CARTAO_CREDITO') {

                $parcela->update(['status' => 0]);

                $pagamento = ParcelasPagamentos::where('parcela_id', $parcela->id)->first();

                $cc = PagamentosCartao::where('parcela_pagamento_id', $pagamento->id)->first();
                $cc->update(['deleted' => 1, 'status' => 'Recusado']);
                return;
                //** Se nao aprovou o cartão nada precisa ser feito */
                /*
            $dataInsert = [
            'items_total_cents' => 0,
            'parcela_pagamento_id' => $transaction->reference,
            'payable_with' => null,
            'status' => $status_trn,
            'due_date' => $date,
            'total' => $transaction->grossAmount,
            'taxes_paid' => 0,
            'total_paid' => 0,
            'total_overpaid' => 0,
            'paid' => $transaction->grossAmount,
            'secure_id' => $transaction->code,
            'secure_url' => $transaction->paymentLink,
            'installments' => $transaction->installmentCount,
            'transaction_number' => null,
            'payment_method' => $tipo_pagamento,
            'paid_at' => $paid_at,
            'deleted' => 1,
            'valor_pago' => 0,
            ];
            PagamentosCartao::create($dataInsert);

             */}
        }

        if ($status_trn == 'Pago') {

            $parcela->update(['status' => 1]);
            $pagamento = ParcelasPagamentos::where('parcela_id', $parcela->id)->first();

            if (!$pagamento) {
                $pagamento = ParcelasPagamentos::create(['parcela_id' => $parcela->id, 'valor_pago' => $transaction->grossAmount]);
            } else {
                $pagamento->update(['valor_pago' => ($transaction->grossAmount), 'deleted' => 0]);
            }

            if ($tipo_pagamento == "BOLETO") {
                $dataInsert = [
                    'valor_pago' => $transaction->grossAmount,
                    'payable_with' => null,
                    'due_date' => $date,
                    'total_cents' => 0,
                    'paid_cents' => 0,
                    'status' => $status_trn,
                    'paid_at' => $paid_at,
                    'secure_url' => $transaction->paymentLink,
                    'taxes_paid_cents' => 0,
                    'deleted' => 0,
                ];

                $pgBoleto = PagamentosBoleto::where('parcela_pagamento_id', $pagamento->id);
                $pgBoleto->update($dataInsert);

                $pgBoletoGet = PagamentosBoleto::where('parcela_pagamento_id', $pagamento->id)->get()->first();

                $parcelaPagamento = ParcelasPagamentos::find($pgBoletoGet->parcela_pagamento_id);
                $parcelaPagamento->update(['valor_pago' => $transaction->grossAmount, 'deleted' => 0]);
            } elseif ($tipo_pagamento == 'CARTAO_CREDITO') {
                $dataInsert = [
                    'items_total_cents' => 0,
                    'payable_with' => null,
                    'status' => $status_trn,
                    'due_date' => $date,
                    'total' => $transaction->grossAmount,
                    'taxes_paid' => 0,
                    'total_paid' => $transaction->grossAmount,
                    'total_overpaid' => 0,
                    'paid' => $transaction->grossAmount,
                    'secure_id' => $transaction->code,
                    'secure_url' => $transaction->paymentLink,
                    'installments' => $transaction->installmentCount,
                    'transaction_number' => null,
                    'payment_method' => $tipo_pagamento,
                    'paid_at' => $paid_at,
                    'deleted' => 0,
                ];

                //dd($parcela->id);

                $dataInsert = [
                    'parcela_pagamento_id' => $pagamento->id,
                    'status' => $status_trn,
                    'payable_with' => 'credit_card',
                    'total' => $transaction->grossAmount,
                    'installments' => $transaction->installmentCount,
                    'invoice_id' => $transaction->code,

                ];

                $pagamentoCartao = PagamentosCartao::where('parcela_pagamento_id', $pagamento->id);

                $pagamentoCartao->update($dataInsert);
            }

            $valor_pago_p = 0;
            $parcels_pago = FormandoProdutosParcelas::where('formandos_produtos_id', $parcela->formandos_produtos_id)->get();
            $sum_pags = [];
            foreach ($parcels_pago as $parcel_p) {
                if (isset($parcel_p->pagamento)) {
                    $sum_pag = $parcel_p->pagamento->sum('valor_pago');
                    $valor_pago_p += $sum_pag;
                    if ($sum_pag <= 0) {
                        $sum_pags[] = $parcel_p->id;
                    }
                }
            }
            //$status = $pseg->cod_status($retorno->status);
            /*
        if (is_array($sum_pags)) {
        foreach ($sum_pags as $p) {

        $parcelsModel = FormandoProdutosParcelas::find($p);
        if ($parcelsModel) {
        foreach ($parcelsModel->pagamento as $pgs) {
        $parcelaPagamento = ParcelasPagamentos::find($pgs->id);

        if ($parcelaPagamento) {
        if ($parcelaPagamento->typepaind) {
        $parcelaPagamento->typepaind->delete();
        }
        $parcelaPagamento->delete();
        }
        }
        $parcelsModel->delete();
        }
        }
        }
         */
        }
    }
}
