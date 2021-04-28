<?php

namespace App\Http\Controllers;

use App\Event;
use App\FormandoProdutosEServicos;
use App\FormandoProdutosParcelas;
use App\Forming;
use App\Notifications\TaskCompleted;
use App\PagamentosBoleto;
use App\ParcelasPagamentos;
use App\Services\IuguService;
use App\Services\TicketServices;
use App\Ticket;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class WebhookController extends Controller
{
    public function geraBoletos(IuguService $iuguService)
    {
        $date = Carbon::now();
        $dateLimit = Carbon::now();
        $dateLimit->addDays(10);

        //dd($date->format('Y-m-d'));

        $parcels = FormandoProdutosParcelas::where('dt_vencimento', '>', "{$date->format('Y-m-d')}")
            ->where('dt_vencimento', '<=', "{$dateLimit->format('Y-m-d')}")->get();

        $logs = [];
        foreach ($parcels as $parcel){

            if($parcel->formando->status != 1){continue;}

            $pagamento = ParcelasPagamentos::where('parcela_id', $parcel->id)->where('deleted', 0)->first();
            if(!isset($pagamento) or $pagamento->count() <= 0){

                $pagamento = ParcelasPagamentos::create(['parcela_id' => $parcel->id,'valor_pago' => 0]);

                if(!$pagamento->typepaind) {
                    //Criar parcela na iugu

                    $data = [
                        'email' => $parcel->formando->email,
                        'due_date' => $parcel->dt_vencimento,
                        "items[]" => [
                            "description" => $parcel->pedido->name . " - Pedido: #" . $parcel->pedido->id . " - Parcela: " . $parcel->numero_parcela,
                            "quantity" => "1",
                            "price_cents" => number_format($parcel->valor, 2, '', '')
                        ],
                        "payer" => [
                            "cpf_cnpj" => $parcel->formando->cpf,
                            "name" => $parcel->formando->nome . " " . $parcel->formando->sobrenome,
                            "address" => [
                                'zip_code' => $parcel->formando->cep,
                                'number' => $parcel->formando->numero
                            ]
                        ],
                        "custom_variables[]" => [
                            "name" => "system",
                            "value" => env('APP_NAME')
                        ],
                        "payable_with" => "bank_slip"
                    ];
                    $retorno = $iuguService->criarBoleto($data);

                    $installments = ($retorno->installments == null ? 0 : $retorno->installments);

                    $dataInsert = [
                        'parcela_pagamento_id' => $pagamento->id,
                        'valor_pago' => IuguService::convertCentsToCurrency($retorno->total_paid_cents),
                        'invoice_id' => $retorno->id,
                        'payable_with' => $retorno->payable_with,
                        'due_date' => $retorno->due_date,
                        'total_cents' => IuguService::convertCentsToCurrency($retorno->total_cents),
                        'paid_cents' => IuguService::convertCentsToCurrency($retorno->paid_cents),
                        'status' => $retorno->status,
                        'paid_at' => $retorno->occurrence_date,
                        'secure_url' => $retorno->secure_url,
                        'taxes_paid_cents' => IuguService::convertCentsToCurrency($retorno->taxes_paid_cents),
                        'installments' => $installments,
                        'digitable_line' => $retorno->bank_slip->digitable_line,
                        'barcode' => $retorno->bank_slip->barcode
                    ];

                    $pagamentoBoleto = PagamentosBoleto::create($dataInsert);


                    $pagamento->typepaind()->associate($pagamentoBoleto);
                    $pagamento->save();

                    $logs[] = ['parcela_id' => $pagamento->id, 'invoice_id' => $retorno->id];
                }
            }
        }

        $logsRet['content'] = '';

        foreach ($logs as $log){
            $logsRet['content'].= "{$log['parcela_id']} | {$log['invoice_id']} <br>";
        }

        Storage::put("logs/geraboletos/{$date->format('Ymd_His')}.txt",$logsRet);

        /*
        $fromMail = 'site@agenciapni.com.br';
        $fromName = 'SiForme GeraBoletos';
        $dataEmail = $logsRet;
        Mail::send('email.geraboletos', $dataEmail, function ($message) use ($fromName, $fromMail){

            $message->to('tecnologia@agenciapni.com.br', 'SiForme System');
            $message->from($fromMail, $fromName);
            $message->subject('SiForme GeraBoletos');

        });
        */

    }


    public function cancelaBoletos(IuguService $iuguService)
    {

        $formings = Forming::where('status', 6)->get();
        foreach ($formings as $forming){


            foreach ($forming->products as $product){
                $parcelas = FormandoProdutosParcelas::where('formandos_produtos_id', $product->id)->get();
                foreach ($parcelas as $parcela){
                    if(isset($parcela->pagamento)){
                        //dd($parcela->pagamento);
                        foreach ($parcela->pagamento as $pags){
                            $pagamento = ParcelasPagamentos::find($pags->id);
                            if($pagamento->typepaind->status != 'canceled'){
                                $iuguService->cancelarInvoice($pagamento->typepaind->invoice_id);
                            }
                        }
                    }
                }
                $product->status = 2;
                $product->save();
            }

            $forming->status = 7;
            $forming->save();
        }

    }

    public function geraTickets()
    {
        $ticketService = new TicketServices();

        $date = Carbon::now()->subDay(1)->format('Y-m-d H:i:s');
        $fps = FormandoProdutosEServicos::where('status', 1)
            ->where('webhook_date', '<', $date)
            ->orderBy('webhook_date')
            ->limit(10)
            ->get();
        $fparray = [];
        foreach ($fps as $fp){
            $fparray[] = $fp->id;


            $events = explode("|", $fp->events_ids);
            foreach ($events as $event){
                if($event == 0){continue;}
                $eventModel = Event::find($event);

                $active_ticket = $eventModel->active_ticket;
                if($active_ticket == 1){

                    $not_paid = $eventModel->not_paid;

                    if($not_paid == 0){
                        $vlosoma = 0;
                        foreach ($fp->parcelas as $p){

                            foreach ($p->pagamento as $pgs){

                                $vlosoma += $pgs->valor_pago;
                            }
                        }
                        if($vlosoma < $fp->valorFinal()){
                            $liberado = false;
                        }else{
                            $liberado = true;
                        }
                    }else{
                        $liberado = true;
                    }


                    if($liberado){
                        $catss = $fp->categorias_tipos->where('category_id', 1);
                        foreach ($catss as $cats){

                            $tickets_in =  $fp->amount * $cats->quantity;
                            $tickets = Ticket::where('event_id', $eventModel->id)->where('status', 1)->where('forming_id', $fp->forming->id)->where('fps_id', $fp->id)->get();
                            $dif = $tickets_in - $tickets->count();
                            //dd($tickets_in, $tickets->count(), $dif, $tickets);
                            if($dif>0){

                                for($i=1;$i<=$dif;$i++){

                                    $tickets = Ticket::where('event_id', $eventModel->id)->where('status', 1)->where('forming_id', $fp->forming->id)->where('fps_id', 0)->first();
                                    if(isset($tickets->id)){
                                        $tickets->fps_id = $fp->id;
                                        $tickets->save();
                                    }else{
                                        $ticketService->geraTicket($eventModel->id, $fp->forming->id, $fp->id);
                                    }

                                }

                                $tickets = Ticket::where('event_id', $eventModel->id)->where('status', 1)->where('forming_id', $fp->forming->id)->where('fps_id', $fp->id)->get();

                            }

                        }
                    }

                }

            }
            $fp->webhook_date = Carbon::now()->format('Y-m-d H:i:s');
            $fp->save();
        }

    }

    public function geraTicketsNull()
    {
        $ticketService = new TicketServices();
        $fps = FormandoProdutosEServicos::where('status', 1)
            ->whereNull('webhook_date')
            ->limit(10)
            ->get();
        $fparray = [];
        foreach ($fps as $fp){
            $fparray[] = $fp->id;


            $events = explode("|", $fp->events_ids);
            foreach ($events as $event){
                if($event == 0){continue;}
                $eventModel = Event::find($event);

                $active_ticket = $eventModel->active_ticket;
                if($active_ticket == 1){

                    $not_paid = $eventModel->not_paid;

                    if($not_paid == 0){
                        $vlosoma = 0;
                        foreach ($fp->parcelas as $p){

                            foreach ($p->pagamento as $pgs){

                                $vlosoma += $pgs->valor_pago;
                            }
                        }
                        if($vlosoma < $fp->valorFinal()){
                            $liberado = false;
                        }else{
                            $liberado = true;
                        }
                    }else{
                        $liberado = true;
                    }


                    if($liberado){
                        $catss = $fp->categorias_tipos->where('category_id', 1);
                        foreach ($catss as $cats){

                            $tickets_in =  $fp->amount * $cats->quantity;
                            $tickets = Ticket::where('event_id', $eventModel->id)->where('status', 1)->where('forming_id', $fp->forming->id)->where('fps_id', $fp->id)->get();
                            $dif = $tickets_in - $tickets->count();
                            //dd($tickets_in, $tickets->count(), $dif, $tickets);
                            if($dif>0){

                                for($i=1;$i<=$dif;$i++){

                                    $tickets = Ticket::where('event_id', $eventModel->id)->where('status', 1)->where('forming_id', $fp->forming->id)->where('fps_id', 0)->first();
                                    if(isset($tickets->id)){
                                        $tickets->fps_id = $fp->id;
                                        $tickets->save();
                                    }else{
                                        $ticketService->geraTicket($eventModel->id, $fp->forming->id, $fp->id);
                                    }

                                }

                                $tickets = Ticket::where('event_id', $eventModel->id)->where('status', 1)->where('forming_id', $fp->forming->id)->where('fps_id', $fp->id)->get();

                            }

                        }
                    }

                }

            }
            $fp->webhook_date = Carbon::now()->format('Y-m-d H:i:s');
            $fp->save();
        }
    }
}
