<?php

namespace App\Http\Controllers;

use App\AuditAndLog;
use App\Chamado;
use App\ConfigApp;
use App\Contract;
use App\Course;
use App\Event;
use App\FormandoProdutosEServicos;
use App\FormandoProdutosEServicosCateriasTipos;
use App\FormandoProdutosParcelas;
use App\Forming;
use App\Gift;
use App\GiftRequests;
use App\GiftRequestsGifts;
use App\Helpers\ConvertData;
use App\Helpers\DateHelper;
use App\Informativo;
use App\Mail\RaffleMail;
use App\PagamentosBoleto;
use App\PagamentosCartao;
use App\ParcelasPagamentos;
use App\ProductAndService;
use App\ProductAndServiceDiscounts;
use App\ProductAndServiceValues;
use App\ProdutosEServicosTermo;
use App\Raffle;
use App\RaffleNumbers;
use App\Services\IuguService;
use App\Services\PagSeguroService;
use App\Services\ProdutosService;
use App\Services\RaffleServices;
use App\Services\TicketServices;
use App\Survey;
use App\SurveyAnswer;
use App\Ticket;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Intervention\Image\Facades\Image;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use RealRashid\SweetAlert\Facades\Alert;

class PortalController extends Controller
{

    public function home()
    {
        
        try {
            if (Auth::user()->userable_type == 'App\Collaborator') {
                return redirect()->route('gerencial.contratos');
            }
            
            
            return redirect()->route('portal.extrato');
        } catch (\Throwable $th) {
            return redirect()->route('login');
        }
        
       
    }

    public function extrato()
    {
        $formando = Auth::user()->userable->id;
        $pedidos = FormandoProdutosEServicos::where('forming_id', $formando)->where('status', 1)->get();
        $dataView = ['pedidos' => $pedidos];

        return view('portal.extrato', $dataView);
    }

    public function extratoProduto(FormandoProdutosEServicos $prod, PagSeguroService $pseg)
    {

        
        $forming_id = \auth()->user()->userable->id;
        
        if ($prod->forming_id != $forming_id) {
            return redirect()->route('erro.404');
        }

        $parcelas = FormandoProdutosParcelas::where('formandos_produtos_id', $prod->id)->get()->toArray();

        $pagamentos = [];
        foreach ($parcelas as $parcela) {
            //$ret = ParcelasPagamentos::where('parcela_id', $parcela['id'])->where('deleted', 0)->first();
            $ret = ParcelasPagamentos::where('parcela_id', $parcela['id'])->first();
            if ($ret) {
                $pagamentos[$parcela['id']] = $ret;
            }
        }

        $valor_pago = 0;
        $parcels = FormandoProdutosParcelas::where('formandos_produtos_id', $prod->id)->where('dt_vencimento', '<', date('Y-m-d'))->get();
        $valor = $parcels->sum('valor');
        //dd($parcels);
        foreach ($parcels as $parcel) {
            if (isset($parcel->pagamento)) {
                $valor_pago += $parcel->pagamento->sum('valor_pago');
            }
        }

        $valor_pago_p = 0;
        $parcels_pago = FormandoProdutosParcelas::where('formandos_produtos_id', $prod->id)->get();
        //dd($parcels_pago);
        foreach ($parcels_pago as $parcel_p) {
            if (isset($parcel_p->pagamento) && $parcel_p['status']) {
                $valor_pago_p += $parcel_p->pagamento->sum('valor_pago');
            }
        }

        if ($valor_pago_p <= 0) {
            $prod_status = 'Pendente';
        } elseif ($valor_pago_p >= 0 and ($valor_pago_p >= $valor)) {
            $prod_status = 'Adimplente';
        } elseif ($valor_pago_p >= 0 and ($valor_pago_p < $valor)) {
            $prod_status = 'Inadimplente';
        }

        $saldo_pagar = ($prod->valorFinal() - $valor_pago_p);

        $date = Carbon::now();
        $dateLimit = Carbon::now();
        $dateLimit->addDays(40);

        //Ingresso
        $events_array = [];
        $events = explode("|", $prod->events_ids);

        foreach ($events as $event) {
            if ($event == 0) {
                continue;
            }
            $event_temp = Event::find($event);
            if ($event_temp->active_ticket == 1) {

                $not_paid = $event_temp->not_paid;

                if ($not_paid == 0) {
                    $vlosoma = 0;
                    foreach ($prod->parcelas as $p) {

                        foreach ($p->pagamento as $pgs) {

                            $vlosoma += $pgs->valor_pago;
                        }
                    }
                    if ($vlosoma < $prod->valorFinal()) {
                        $liberado = false;
                    } else {
                        $liberado = true;
                    }
                } else {
                    $liberado = true;
                }

                if ($liberado) {

                    $events_array[$event_temp->id]['event'] = $event_temp;
                    $events_array[$event_temp->id]['tickets'] = [];

                    $catstypes = $prod->categorias_tipos->where('category_id', 1);

                    foreach ($catstypes as $cats) {

                        $tickets_in = $cats->quantity * $prod->amount;
                        $tickets = Ticket::where('event_id', $event_temp->id)->where('forming_id', $forming_id)->where('fps_id', $prod->id)->where('status', 1)->get();
                        $dif = $tickets_in - $tickets->count();
                        if ($dif > 0) {

                            $ticketService = new TicketServices();

                            for ($i = 1; $i <= $dif; $i++) {

                                $tickets = Ticket::where('event_id', $event_temp->id)->where('forming_id', $forming_id)->where('fps_id', 0)->where('status', 1)->first();
                                if (isset($tickets->id)) {
                                    $tickets->fps_id = $prod->id;
                                    $tickets->save();
                                } else {
                                    $ticketService->geraTicket($event_temp->id, $forming_id, $prod->id);
                                }
                            }

                            $tickets = Ticket::where('event_id', $event_temp->id)->where('forming_id', $forming_id)->where('fps_id', $prod->id)->where('status', 1)->get();
                        }

                        $events_array[$event_temp->id]['tickets'] = $tickets;
                        //dd('ok');

                    }
                }
            }

            //dd($event_temp);
        }

        //dd($valor_pago, $valor);

        $produtos = $prod->get()->toArray();
        $termo = ProdutosEServicosTermo::where('id', $prod['termo_id'])->get()->toArray()[0];
        $termo = str_replace('[[=valor]]', number_format($prod->valorFinal(), 2, ',', '.'), $termo);

        $logoimini = '/public/img/logo_i_mini.png';
        $logo = asset('img/logo.png');

        if (isset($pagamentos[$parcela['id']]->typepaind_type) && $pagamentos[$parcela['id']]->typepaind_type == 'App\PagamentosCartao') {
            $pgto = PagamentosCartao::where('parcela_pagamento_id', $pagamentos[$parcela['id']]->id)->get()->toArray()[0];
        } else {
            $pgto = null;
        }

        AuditAndLog::createLog(Auth::user()->id, 'Acessou Extrato Produtos: ' . $prod->name . ' - ID#' . $prod->id, 'null', Auth::user()->userable->contract_id);

        $id_sessao = $pseg->geraSessao();
        $disable_cc_pgto = false;
        
        return view('portal.extrato_detalhe', compact('prod', 'parcelas', 'termo', 'pagamentos', 'prod_status', 'date', 'dateLimit', 'saldo_pagar', 'valor_pago_p', 'events_array', 'logoimini', 'logo', 'id_sessao', 'pgto', 'disable_cc_pgto'));
    }

    public function extratoProdutoPayCredit(FormandoProdutosEServicos $prod, PagSeguroService $pseg)
    {

        if ($prod->forming_id != \auth()->user()->userable->id) {
            return redirect()->route('erro.404');
        }
        $parcelas = FormandoProdutosParcelas::where('formandos_produtos_id', $prod->id)->get()->toArray();

        $pagamentos = [];
        foreach ($parcelas as $parcela) {
            $ret = ParcelasPagamentos::where('parcela_id', $parcela['id'])->where('deleted', 0)->first();
            if ($ret) {
                $pagamentos[$parcela['id']] = $ret;
            }
        }

        $valor_pago = 0;
        $parcels = FormandoProdutosParcelas::where('formandos_produtos_id', $prod->id)->where('dt_vencimento', '<', date('Y-m-d'))->get();
        $valor = $parcels->sum('valor');

        foreach ($parcels as $parcel) {
            if (isset($parcel->pagamento)) {
                $sum_pag = $parcel->pagamento->sum('valor_pago');
                $valor_pago += $sum_pag;
            }
        }

        $valor_pago_p = 0;
        $parcels_pago = FormandoProdutosParcelas::where('formandos_produtos_id', $prod->id)->get();
        $sum_pags = [];
        foreach ($parcels_pago as $parcel_p) {
            if (isset($parcel_p->pagamento) && $parcel_p['status']) {
                $sum_pag = $parcel_p->pagamento->sum('valor_pago');
                $valor_pago_p += $sum_pag;
                if ($sum_pag <= 0) {
                    $sum_pags[] = $parcel_p->id;
                }
            }
        }

        if ($valor_pago_p <= 0) {
            $prod_status = 'Pendente';
        } elseif ($valor_pago_p >= 0 and ($valor_pago_p >= $valor)) {
            $prod_status = 'Adimplente';
        } elseif ($valor_pago_p >= 0 and ($valor_pago_p < $valor)) {
            $prod_status = 'Inadimplente';
        }

        $saldo_pagar = ($prod->valorFinal() - $valor_pago_p);

        $date = Carbon::now();
        $dateLimit = Carbon::now();
        $dateLimit->addDays(40);

        //dd($valor_pago, $valor);

        $produtos = $prod->get()->toArray();

        $parcels_max = FormandoProdutosParcelas::where('formandos_produtos_id', $prod->id)->where('dt_vencimento', '>=', date('Y-m-d'))->get();
        $parce_max = $parcels_max->count();
        $parce_max = ($parce_max > 12) ? 12 : $parce_max;
        $parce_max = ($parce_max <= 0) ? 1 : $parce_max;
        $id_sessao = $pseg->geraSessao();
        
        AuditAndLog::createLog(Auth::user()->id, 'Acessou Extrato Produtos: ' . $prod->name . ' - ID#' . $prod->id, 'null', Auth::user()->userable->contract_id);
        return view('portal.extrato_produto_paycredit', compact('prod', 'parcelas', 'pagamentos', 'prod_status', 'date', 'dateLimit', 'saldo_pagar', 'valor_pago_p', 'parce_max', 'sum_pags', 'id_sessao'));
    }

    public function extratoProdutoPayCreditProcess(FormandoProdutosEServicos $prod, Request $request)
    {

        $forming = Forming::find($prod->forming_id);

        //$saldo = $request->get('saldo');
        $saldo = $prod->value;
//dd($request->all());

        $data = [
            "email" => $forming->email,
            'token' => $request->get('token'),
            "items[]" => [
                "description" => $prod->name . " #" . $prod->id,
                "quantity" => "1",
                "price_cents" => number_format($saldo, 2, "", ""),
            ],
            "months" => $request->get('pay-parcels'),
        ];
        $hash_pseg = $request->get('hash');
        $token_cartao = $request->get('token');
        $parcel_aux = explode('x', $request->get('pay-parcels'));
        $pag_parcela_qtd = $parcel_aux[0];
        //dd($pag_parcela_qtd);
        if ($pag_parcela_qtd > 6) {

            $request->session()->flash("process_message", "A quantidade de parcelas escolhidas não é permitida");
            return redirect()->route("portal.extrato.produto.paycredit", ["prod" => $prod->id]);
        }
        $pag_valor_parcela = $parcel_aux[1];
        $nome_titular = $request->get('nome_cc');
        $cpf_tit = $request->get('cpf_tit');
        $cpf_tit = str_replace('-', '', $cpf_tit);
        $cpf_tit = str_replace('.', '', $cpf_tit);
        $data_nasc = $request->get('data_nasc');

        $parcelsMax = FormandoProdutosParcelas::where('formandos_produtos_id', $prod->id)->max('numero_parcela');
        $parcelsMax++;

        $parcela = FormandoProdutosParcelas::create(
            [
                'formandos_produtos_id' => $prod->id,
                'formandos_id' => $forming->id,
                'contrato_id' => $forming->contract_id,
                'dt_vencimento' => date("Y-m-d"),
                'numero_parcela' => $parcelsMax,
                'valor' => $saldo,
                'status' => 1,
            ]
        );
        //$pagamento = ParcelasPagamentos::create(['parcela_id' => $parcela->id, 'valor_pago' =>0]);

        $numero = is_null($parcela->formando->telefone_celular) ? $parcela->formando->telefone_residencial : $parcela->formando->telefone_celular;

        $ddd_cliente = substr($numero, 0, 2);
        $numero_cliente = substr($numero, 2);
        $contrato = Contract::find($forming->contract_id);

        $dados_compra = array(
            'paymentMode' => ('default'),
            'paymentMethod' => ('creditCard'),
            'currency' => ('BRL'),
            'extraAmount' => ('0.00'),
            'itemId1' => ($prod->contract_id),
            'itemDescription1' => ($prod->description),
            'itemAmount1' => number_format($saldo, 2, '.', ''),
            'noInterestInstallmentQuantity' => 6,
            'itemQuantity1' => '1',
            'notificationURL' => env('APP_URL') . '/webhook/pseg?contrato=' . Auth::user()->userable->contract_id,
            'reference' => ($parcela->id),
            'senderName' => $forming->nome . ' ' . $forming->sobrenome,
            'senderCPF' => ($forming->cpf),
            'senderAreaCode' => ($ddd_cliente),
            'senderPhone' => ($numero_cliente),
            'senderEmail' => ($forming->email),
            //'senderEmail' => urlencode('comprador@sandbox.pagseguro.com.br'),
            'senderHash' => ($hash_pseg),
            'shippingAddressStreet' => $parcela->formando->logradouro,
            'shippingAddressNumber' => $parcela->formando->numero,
            'shippingAddressComplement' => $parcela->formando->complemento,
            'shippingAddressDistrict' => $parcela->formando->bairro,
            'shippingAddressPostalCode' => $parcela->formando->cep,
            'shippingAddressCity' => $parcela->formando->cidade,
            'shippingAddressState' => $parcela->formando->estado,
            'shippingAddressCountry' => 'BRA',
            'shippingType' => ('1'),
            'creditCardToken' => ($token_cartao),
            'installmentQuantity' => ($pag_parcela_qtd),
            'installmentValue' => ($pag_valor_parcela),
            'creditCardHolderName' => ($nome_titular),
            'creditCardHolderCPF' => $cpf_tit,
            'creditCardHolderBirthDate' => $data_nasc,
            'creditCardHolderAreaCode' => ($ddd_cliente),
            'creditCardHolderPhone' => ($numero_cliente),
            'billingAddressStreet' => ($parcela->formando->logradouro),
            'billingAddressNumber' => ($parcela->formando->numero),
            'billingAddressComplement' => ($parcela->formando->complemento),
            'billingAddressDistrict' => ($parcela->formando->bairro),
            'billingAddressPostalCode' => ($parcela->formando->cep),
            'billingAddressCity' => ($parcela->formando->cidade),
            'billingAddressState' => ($parcela->formando->estado),
            'billingAddressCountry' => ('BRA'),
        );
//dd($dados_compra);

        $pseg = new PagSeguroService();
        Log::debug('ENVIO criacao pgto cartao pseg: ' . json_encode($dados_compra));
        $retorno = $pseg->criarCartao($dados_compra);

        Log::debug('RETORNO criacao pgto cartao pseg: ' . json_encode($retorno));
        //dd($retorno);

        if (!isset($retorno->status)) {
            return redirect()->route("portal.extrato.produto.paycredit", ["prod" => $prod->id]);
        }

        $parcels = $request->get('parcels');

        if (is_array($parcels)) {
            foreach ($parcels as $p) {

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

        $pagamento = ParcelasPagamentos::create(['parcela_id' => $parcela->id, 'valor_pago' => 0]);

        $dataInsert = [
            'parcela_pagamento_id' => $pagamento->id,
            'status' => $pseg->cod_status($retorno->status),
            'payable_with' => 'credit_card',
            'total' => 0,
            'installments' => $retorno->installmentCount,
            'invoice_id' => $retorno->code,

        ];

        $pagamentoCartao = PagamentosCartao::create($dataInsert);

        $pagamento->typepaind()->associate($pagamentoCartao);
        $pagamento->save();

        if ($pseg->cod_status($retorno->status) == 'Pago') {

            $pagamento->update(['valor_pago' => $saldo]);
            $pagamentoCartao->update(['total' => $retorno->grossAmount]);

            $request->session()->flash("process_success_msg", "Compra de código " . $retorno->code . " APROVADA!");
            //$request->session()->flash("process_lr", $retorno->LR);
            return redirect()->route("portal.extrato.produto.paycredit", ["prod" => $prod->id]);
        }
/*
$dataInsert = [
'parcela_pagamento_id' => $pagamento->id,
'status' => $pseg->cod_status($retorno->status),
'payable_with' => 'credit_card',
'total' => $retorno->grossAmount,
'installments' => $retorno->installmentCount,
'invoice_id' => $retorno->code,

];

$pagamentoCartao = PagamentosCartao::create($dataInsert);

$pagamento->typepaind()->associate($pagamentoCartao);
$pagamento->save();

//$status = $pseg->cod_status($retorno->status);
$parcels = $request->get('parcels');
//dd($parcels);
if (is_array($parcels)) {
foreach ($parcels as $p) {

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

        $request->session()->flash("process_success_msg", "processado, estamos aguardando a aprovação da compra");
        return redirect()->route("portal.extrato.produto", ["prod" => $prod->id]);

    }

    public function boleto(FormandoProdutosParcelas $parcela, PagSeguroService $gatewayService, $hash_pseg = null)
    {
        //dd($hash_pseg);
        if (is_null($hash_pseg)) {
            return redirect()->back();
        }

        //$ret = $gatewayService->consultarTransacao('57BBA86F0D354C46A5D75F4915428EE3');
        //dd($ret);
        
        if (auth()->user()->userable_id != $parcela->formando->id) {
            die('erro 55');
        }

        $pagamento = ParcelasPagamentos::where('parcela_id', $parcela->id)->where('deleted', 0)->get()->first();
        $contrato = Contract::where('id', Auth::user()->userable->contract_id)->get()->toArray()[0];

        if (!$pagamento) {
            $pagamento = ParcelasPagamentos::create(['parcela_id' => $parcela->id, 'valor_pago' => 0]);
        }

        
        if (!$pagamento->typepaind) {
        //if (true) {
            
            //$novo_vencimento = date('Y-m-d', strtotime("+1 days"));
            $novo_vencimento = $parcela->dt_vencimento;

            if (date('Y-m-d') > date('Y-m-d', strtotime($parcela->dt_vencimento))) {
                $juros = new \App\Helpers\Juros($parcela->valor, date('d/m/Y', strtotime($parcela->dt_vencimento)), 2, 0.03);

                if ($juros->VerificaBoleto()) {
                    $juros->CalculaOsJuros();
                    $valor_antigo = $parcela->valor;
                    $venc_antigo = $parcela->dt_vencimento;

                    $getJurosTotal = number_format(str_replace(",", ".", $juros->getJurosTotal()), 2, '.', '');
                    $getMultaTotal = number_format(str_replace(",", ".", $juros->getMultaTotal()), 2, '.', '');
                    $valor = $parcela->valor;
                    $novo_valor = $valor + $getJurosTotal + $getMultaTotal;
                    $novo_valor = number_format($novo_valor, 2, '.', '');

                    $dataParcela = [
                        'dt_vencimento' => $novo_vencimento,
                        'valor' => $novo_valor,
                    ];

                    $parcela->update($dataParcela);

                    $parcela = FormandoProdutosParcelas::find($parcela->id);
                    AuditAndLog::createLog(Auth::user()->id, 'Boleto em Atraso Atualizado: ' . $parcela->id . ' - Parcela:  ' . $parcela->numero_parcela . ' | Valor Antigo: ' . $valor_antigo . ' | Data de Vencimento Antiga: ' . $venc_antigo . ' | Dias de atraso: ' . $juros->getDiasEmAberto() . ' | Multa: ' . $juros->getMultaTotal() . ' | Juros: ' . $juros->getJurosTotal() . ' | Novo Vencimento: ' . $novo_vencimento . ' | Novo valor: ' . $juros->getValorTotal(), 'null', Auth::user()->userable->contract_id);

                }
            }

            $val_boleto = isset($novo_valor) ? $novo_valor : $parcela->valor;

            $numero = is_null($parcela->formando->telefone_celular) ? $parcela->formando->telefone_residencial : $parcela->formando->telefone_celular;

            $ddd_cliente = substr($numero, 0, 2);
            $numero_cliente = substr($numero, 2);
            //dd($novo_vencimento);
            $data = [
                'paymentMode' => 'default',
                'paymentMethod' => 'boleto',
                'firstDueDate' => $novo_vencimento,
                'currency' => 'BRL',
                'extraAmount' => number_format(0, 2),
                'itemId1' => $pagamento->id,
                'itemDescription1' => 'boleto ' . env('APP_NAME') . ' ' . $contrato['name'],
                'itemAmount1' => number_format($val_boleto, 2, '.', ''),
                'itemQuantity1' => 1,
                'notificationURL' => env('APP_URL') . '/webhook/pseg?contrato=' . $contrato['pseg_acc'],
                'reference' => $parcela->id,
                "senderName" => $parcela->formando->nome . " " . $parcela->formando->sobrenome,
                "senderCPF" => $parcela->formando->cpf,
                "senderAreaCode" => $ddd_cliente,
                "senderPhone" => $numero_cliente,
                'senderEmail' => $parcela->formando->email,
                'senderHash' => $hash_pseg,
                'shippingAddressStreet' => $parcela->formando->logradouro,
                'shippingAddressNumber' => $parcela->formando->numero,
                'shippingAddressComplement' => $parcela->formando->complemento,
                'shippingAddressDistrict' => $parcela->formando->bairro,
                'shippingAddressPostalCode' => $parcela->formando->cep,
                'shippingAddressCity' => $parcela->formando->cidade,
                'shippingAddressState' => $parcela->formando->estado,
                'shippingAddressCountry' => 'BRA',
            ];
//dd($data);
            $retorno = $gatewayService->criarBoleto($data);
            // dd($retorno);
            //var_dump( ($retorno));exit;
            if (!isset($retorno->status)) {
                if (preg_match('~<code>(.*?)</code>~', $retorno, $match) == 1) {
                    //echo $match[1];
                    echo $gatewayService->error_list($match[1]);
                    exit;
                }
                //die("Erro ao tentar emitir boleto, favor entre em contato com nosso atendimento contato@arrecadeei.com.br");
            }

            //$installments = ($retorno->installments == null ? 0 : $retorno->installmentCount);
            if (isset($retorno->installments)) {
                $installments = $retorno->installments;
            } else {
                $installments = 0;
            }
            $status = $gatewayService->cod_status($retorno->status);
            $date = new DateTime($retorno->date);

            $dataInsert = [
                'parcela_pagamento_id' => $pagamento->id,
                'valor_pago' => $retorno->grossAmount,
                'invoice_id' => $retorno->code,
                'payable_with' => null,
                'due_date' => $date,
                'total_cents' => 0,
                'paid_cents' => 0,
                'status' => $status,
                'paid_at' => null,
                'secure_url' => $retorno->paymentLink,
                'taxes_paid_cents' => 0,
                'installments' => $installments,
                'digitable_line' => "",
                'barcode' => "",
            ];

            $pagamentoBoleto = PagamentosBoleto::create($dataInsert);

            $pagamento->typepaind()->associate($pagamentoBoleto);
            $pagamento->save();
        }

        AuditAndLog::createLog(Auth::user()->id, 'Imprimiu Boleto: ' . $parcela->pedido->name . ' - Parcela:  ' . $parcela->numero_parcela . ' - ID#' . $parcela->pedido->id, 'null', Auth::user()->userable->contract_id);

        return redirect($pagamento->typepaind->secure_url);
    }

    public function perfil()
    {
        $formando = \auth()->user()->userable()->get()->toArray()[0];

        //Altura
        $i_altura = [];
        for ($i = 1.40; $i <= 2.10; $i += 0.01) {
            $i_altura["" . $i . ""] = str_replace(".", ",", number_format($i, 2, ",", "."));
        }

        //Camiseta
        $camiseta = [
            'P' => 'P',
            'M' => 'M',
            'G' => 'G',
            'GG' => 'GG',
            'EG' => 'EG',
        ];

        //Calçado
        $calcado = ConfigApp::Calcados();

        $curso = Course::find($formando['curso_id'])['name'];
        $formando['curso'] = $curso;
        $formando['periodos'] = ConfigApp::Periodos();
        $contrato = Contract::where('id', $formando['contract_id'])->get()->toArray()[0];

        return view('portal.perfil', compact('formando', 'i_altura', 'calcado', 'camiseta', 'contrato'));
    }

    public function perfilUpdate(Request $request)
    {
        $this->validate($request, [
            "nome" => "required",
            "sobrenome" => "required",
            "sexo" => "required",
            "date_nascimento" => "required",
            "rg" => "required",
            "cep" => "required",
            //"email" => "required|email",
            "telefone_celular" => "required",
            "altura" => "required",
            "camiseta" => "required",
            "calcado" => "required",
            'password' => 'confirmed',
            'password_confirmation' => '',
            'estado' => "required|max:2",
        ]);

        $dadosUpdate = $request->all();
        unset($dadosUpdate['cpf']);
        $dadosUpdate['altura'] = floatval(str_replace("'", "", $dadosUpdate['altura']));
        $formando = Forming::find(\auth()->user()->userable->id);
        $logFormings = $formando->toArray();
        $formando->update($dadosUpdate);
        $password = $request->get('password');
        if (isset($password) and !empty($password)) {
            $formando->user->password = bcrypt($request->get('password'));
            $formando->user->save();
        }
        $userData = [
            'name' => $dadosUpdate['nome'] . " " . $dadosUpdate['sobrenome'],
        ];
        $formando->user()->update($userData);
        AuditAndLog::createLog(Auth::user()->id, 'Atualizou dados', 'json', Auth::user()->userable->contract_id, json_encode($logFormings), json_encode($formando->toArray()));
        $request->session()->flash('msg', 'Dados alterados com sucesso');
        return redirect()->route('portal.perfil');
    }

    public function chamados()
    {
        $formando_id = \auth()->user()->userable->id;
        $chamados_abertos = Chamado::where('forming_id', '=', $formando_id)->whereIn('status', [1, 6])->get()->toArray();
        $chamados_finalizados = Chamado::where('forming_id', '=', $formando_id)->where('status', '=', 2)->get()->toArray();
        return view('portal.chamados', compact('chamados_abertos', 'chamados_finalizados'));
    }

    public function chamadosAbrir()
    {

        return view('portal.chamado_abrir');
    }

    public function chamadosStore(Request $request)
    {
        $this->validate($request, [
            "setor_chamado" => "required",
            "assunto_chamado" => "required|not_in:0",
            "titulo" => "required",
            'descricao' => 'required',
        ]);

        $dt_now = Carbon::now();
        $dt_now->addDays(2);
        if ($dt_now->dayOfWeek == 6) {
            $dt_now->addDays(2);
        } elseif ($dt_now->dayOfWeek == 0) {
            $dt_now->addDays(1);
        }
        //dd($dt_now->format('d/m/y'));
        $dataDb = $request->all();
        $dataDb['data_limite'] = $dt_now->format('Y-m-d');
        $dataDb['forming_id'] = \auth()->user()->userable->id;
        $dataDb['status'] = 1;
        $chamado = Chamado::create($dataDb);
        AuditAndLog::createLog(Auth::user()->id, "Abriu Chamado: {$chamado->titulo} - ID#{$chamado->id}", 'null', Auth::user()->userable->contract_id);

        /*  Send Slack Notification  */
        $forming = Forming::find($dataDb['forming_id']);
        $slack = new \App\Services\SlackService('https://hooks.slack.com/services/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');
        $msg_slack = "Novo Chamado Criado\n -- \n Formando: {$forming->nome} {$forming->sobrenome}\n Contrato: {$forming->contract->name}\n -- \n Titulo: {$dataDb['titulo']}\n Mensagem: {$dataDb['descricao']}\n Link: " . route('gerencial.called.show', ['chamado' => $chamado->id]);
        $slack->SendNotification($msg_slack);

        return redirect()->route('portal.chamados');
    }

    public function chamadosShow(Chamado $chamado)
    {
        AuditAndLog::createLog(Auth::user()->id, "Visualizou Chamado: " . $chamado->titulo . " - ID#{$chamado->id}", 'null', Auth::user()->userable->contract_id);
        return view('portal.chamados_show', compact('chamado'));
    }

    public function chamadosConversasStore(Request $request, Chamado $chamado)
    {
        $dataDb = $request->all();
        $dataDb['user_id'] = \auth()->user()->id;
        $chamado->conversas()->create($dataDb);
        return redirect()->route('portal.chamados.show', ['chamado' => $chamado->id]);
    }

    public function informativos()
    {
        $contrato = Contract::find(\auth()->user()->userable->contract_id);
        return view('portal.informativos', compact('contrato'));
    }

    public function informativosShow(Informativo $informativo)
    {
        if ($informativo->status == 0) {
            $informativo->status = 1;
            $informativo->save();
        }
        AuditAndLog::createLog(Auth::user()->id, "Visualizou Boletim Informativo: " . $informativo->titulo . " - ID#{$informativo->id}", 'null', Auth::user()->userable->contract_id);
        return view('portal.informativos_show', compact('informativo'));
    }

    public function comissao()
    {
        $contractId = auth()->user()->userable->contract_id;
        $comissao = Forming::where('comissao', 1)->where('contract_id', $contractId)->get();
        return view('portal.comissao', compact('comissao'));
    }

    public function comprasExtras()
    {

        $contrato = Contract::find(\auth()->user()->userable->contract_id);
        $mes = DateHelper::ConvertMonth($contrato->conclusion_month);
        $date_now = date("Y-m-d H:i:s");
        $user = \auth()->user()->userable;
        $products = ProductAndService::where('contract_id', $contrato->id)->where('date_start', '<=', $date_now)->where('date_end', '>', $date_now)->where('category_id', 6)->get()->toArray();

        foreach ($products as $p) {

            $product[$p['id']] = $p;

            $values = ProductAndServiceValues::where('products_and_services_id', $p['id'])
                ->where('date_start', '<=', date('Y-m-d H:i:s'))
                ->where('date_end', '>', date('Y-m-d H:i:s'))
                ->get()->first()->toArray();

            $product[$p['id']]['values'] = $values;
            $product[$p['id']]['termo'] = ProdutosEServicosTermo::where('id', '=', $p['termo_id'])->get()->toArray()[0];
            $product[$p['id']]['termo'] = str_replace('[[=valor]]', number_format($product[$p['id']]['values']['value'], 2, ',', '.'), $product[$p['id']]['termo']);

            $discounts = ProductAndServiceDiscounts::where('products_and_services_id', $p['id'])
                ->where('date_start', '<=', date('Y-m-d H:i:s'))
                ->where('date_end', '>', date('Y-m-d H:i:s'))
                ->get()->toArray();

            foreach ($discounts as $d) {
                $product[$p['id']]['discounts'][$d['maximum_parcels']] = $d;
            }

            $product[$p['id']]['max_parcels'] = ConvertData::calculaParcelasMeses(date('Y-m-d', strtotime($product[$p['id']]['values']['date_start'])), $product[$p['id']]['values']['maximum_parcels']);

            //$product[$p['id']]['discounts'] = $discounts;

        }

        if (count($products) <= 0) {
            $product = null;
        }

        return view('portal.comprasextras', ['product' => $product]);
    }

    public function comprasExtrasComprar(ProductAndService $produto, $quantidade, $dia_pagamento, $tppg = 'boleto')
    {

        //        echo "<pre>";
        //        for($i=1; $i<= 3200; $i+=1){
        //            echo rand(1223372036854775809, 6223372036854775809)."<br>";
        //        }
        //        exit;
        $tipo_pagamento = $tppg;

        $user = \auth()->user()->userable;

        $cond1 = date("Y-m-d H:i:s") < $produto->date_start;
        $cond2 = date("Y-m-d H:i:s") > $produto->date_end;

        if ($cond1 or $cond2) {
            return abort(404);
        }

        $product['product'] = $produto;

        $values = ProductAndServiceValues::where('products_and_services_id', $produto->id)
            ->where('date_start', '<=', date('Y-m-d H:i:s'))
            ->where('date_end', '>', date('Y-m-d H:i:s'))
            ->get()->first()->toArray();

        $product['values'] = $values;
        $product['termo'] = ProdutosEServicosTermo::where('id', '=', $product['product']['termo_id'])->get()->toArray()[0];
        $product['termo'] = str_replace('[[=valor]]', number_format($product['values']['value'], 2, ',', '.'), $product['termo']);

        $discounts = ProductAndServiceDiscounts::where('products_and_services_id', $produto->id)
            ->where('date_start', '<=', date('Y-m-d H:i:s'))
            ->where('date_end', '>', date('Y-m-d H:i:s'))
            ->get()->toArray();

        foreach ($discounts as $d) {
            $product['discounts'][$d['maximum_parcels']] = $d;
        }
        //Peculariedade FEI
        $forming = Auth::user()->userable;
        //        if($forming->contract_id == 7){
        //            $dia_pagamento = 30;
        //        }

        $date_inicio = date('Y-m-d', strtotime($product['values']['date_start']));
        $maximum_parcls = $product['values']['maximum_parcels'];
        $product['max_parcels'] = ConvertData::calculaParcelasMeses($date_inicio, $product['values']['maximum_parcels']);
        $max_parls = ConvertData::geraParcelasProdutos($date_inicio, $maximum_parcls, $dia_pagamento);

        //Peculariedade FEI
        if ($product['product']->id == 34 or $product['product']->id == 55) {
            if ($tipo_pagamento == 'boleto') {

                if ($quantidade >= 8) {
                    $max_parls = 10;
                } elseif ($quantidade >= 4) {
                    $max_parls = 6;
                } else {
                    $max_parls = 3;
                }
            } else {

                if ($quantidade >= 8) {
                    $max_parls = 12;
                } elseif ($quantidade >= 4) {
                    $max_parls = 8;
                } else {
                    $max_parls = 5;
                }
            }
        }
        //FIM Peculariedade FEI

        //Peculariedade USJT & FMU
        if ($product['product']->id == 35 or $product['product']->id == 36) {
            if ($tipo_pagamento == 'boleto') {

                if ($quantidade >= 8) {
                    $max_parls = 8;
                } elseif ($quantidade >= 4) {
                    $max_parls = 6;
                } else {
                    $max_parls = 3;
                }
            } else {

                if ($quantidade >= 8) {
                    $max_parls = 10;
                } elseif ($quantidade >= 4) {
                    $max_parls = 8;
                } else {
                    $max_parls = 5;
                }
            }
        }
        //FIM Peculariedade USJT & FMU

        //Peculariedade FEI Pré-evento Maresias
        if ($product['product']->id == 37) {
            if ($tipo_pagamento == 'boleto') {

                if ($quantidade >= 1) {
                    $max_parls = 4;
                }
            } else {

                if ($quantidade >= 1) {
                    $max_parls = 4;
                }
            }
        }
        //FIM Peculariedade FEI Pré-evento Maresias

        //Peculariedade FEI Pré-evento Maresias
        if ($product['product']->id == 38) {
            if ($tipo_pagamento == 'boleto') {

                if ($quantidade >= 1) {
                    $max_parls = 2;
                }
            } else {

                if ($quantidade >= 1) {
                    $max_parls = 2;
                }
            }
        }
        //FIM Peculariedade FEI Pré-evento Maresias

        $valor = ($product['values']['value'] * $quantidade);
        for ($i = 1; $i <= $max_parls; $i++) {

            $disc = 0;
            if (isset($product['discounts']) and is_array($product['discounts'])) {

                $discounts_array = $product['discounts'];
                //dd($discounts_array);
                krsort($discounts_array);
                //dd($discounts_array);
                foreach ($discounts_array as $k => $v) {
                    if ($v['maximum_parcels'] >= $i) {
                        if ($tipo_pagamento == 'credit') {
                            $disc = $v['value_credit_card'];
                        } else {
                            $disc = $v['value'];
                        }
                    }
                }
            }

            $valorProd = ($valor - ($valor * ($disc / 100)));
            $vl_parcela = ($valorProd / $i);
            $vlfor = number_format($vl_parcela, 2, ',', '.');
            $disc_label = ($disc > 0 ? "C/ {$disc}% de desconto" : "");
            $product['parcels'][$i] = "{$i}X de R$ {$vlfor} = R$ " . number_format($valorProd, 2, ",", '.') . " {$disc_label} ";
        }
        foreach ($product['max_parcels'] as $parcela) {
            $product['selectDiaPagamento'][date("d", strtotime($parcela['priPagamento']))] = date("d/m/Y", strtotime($parcela['priPagamento']));
        }

        //Peculariedade FEI
        if ($forming->contract_id == 7 and $product['product']->id == 28) {
            $datetemp = Carbon::now();
            if (date("Y-m-d") <= date("Y-m-d", strtotime('2019-08-14'))) {
                $datetemp->addDay(1);
            }
            if ($datetemp->format('l') == 'Saturday') {
                $datetemp->addDay(2);
            } elseif ($datetemp->format('l') == 'Sunday') {
                $datetemp->addDay(1);
            }
            $product['selectDiaPagamento'] = [(int) $datetemp->format('d') => $datetemp->format('d/m/Y')];
            //dd($product);
        }

        // Verifica estoque
        $compras = \App\Services\ProdutosService::verificarEstoque($produto);

        $estoque = ($produto->stock - $compras['vendas']);

        $compras_por_formando = ProdutosService::verificarEstoquePorFormando($produto, $forming);

        $limite_por_formando = $produto->limit_per_form - $compras_por_formando['vendas'];

        if ($produto->limit_per_form > 0) {
            $estoque = ($estoque > $limite_por_formando) ? $limite_por_formando : $estoque;
        } else {
            $estoque = ($estoque > $produto->limit_per_purchase) ? $produto->limit_per_purchase : $estoque;
        }
//remover
        $estoque = 1;

        //Gera as parcelas
        for ($i = 1; $i <= $estoque; $i++) {
            $selectQuantidade[$i] = $i;
        }
        if (!isset($selectQuantidade)) {
            $product['selectQuantidade'] = 0;
        } else {
            $product['selectQuantidade'] = $selectQuantidade;
        }

        return view('portal.comprasextras_comprar', ['product' => $product, 'quantidade' => $quantidade, 'dia_pagamento' => $dia_pagamento, 'tipo_pagamento' => $tipo_pagamento]);
    }

    public function comprasExtrasStore(Request $request)
    {
        $data = $request->all();
        $produto = ProductAndService::find($data['prodId']);
        $formando = Forming::find(\auth()->user()->userable->id);
        $contrato['id'] = \auth()->user()->userable->contract_id;
        $product = [];

        if ($data['tp_pg'] == 'credit') {

            $values = ProductAndServiceValues::where('products_and_services_id', $produto->id)
                ->where('date_start', '<=', date('Y-m-d H:i:s'))
                ->where('date_end', '>', date('Y-m-d H:i:s'))
                ->get()->first()->toArray();

            $product[$produto->id]['values'] = $values;

            $discounts = ProductAndServiceDiscounts::where('products_and_services_id', $produto->id)
                ->where('date_start', '<=', date('Y-m-d H:i:s'))
                ->where('date_end', '>', date('Y-m-d H:i:s'))
                ->get()->toArray();

            foreach ($discounts as $d) {
                $product[$produto->id]['discounts'][$d['maximum_parcels']] = $d;
            }
            @ksort($product[$produto->id]['discounts']);

            $date_inicio = date('Y-m-d', strtotime($product[$produto->id]['values']['date_start']));
            $maximum_parcls = $product[$produto->id]['values']['maximum_parcels'];
            if (date('m') == 2) {
                $day = 28;
            } else {
                $day = 30;
            }

            $max_parls = ConvertData::geraParcelasProdutos($date_inicio, $maximum_parcls, $day);
            $valor = $product[$produto->id]['values']['value'];

            for ($i = 1; $i <= $max_parls; $i++) {

                $disc = 0;
                if (isset($product[$produto->id]['discounts']) and is_array($product[$produto->id]['discounts'])) {

                    $discounts_array = $product[$produto->id]['discounts'];
                    //dd($discounts_array);
                    krsort($discounts_array);
                    //dd($discounts_array);
                    foreach ($discounts_array as $k => $v) {
                        if ($v['maximum_parcels'] >= $i) {
                            $disc = $v['value_credit_card'];
                        }
                    }
                }
                $valorProd = ($valor - ($valor * ($disc / 100)));
                $vl_parcela = ($valorProd / $i);
                $vlfor = number_format($vl_parcela, 2, '.', '');
                $disc_label = ($disc > 0 ? "C/ {$disc}% de desconto" : "");
                $product[$produto->id]['parcels'][$i] = ['valorCheio' => $valor, 'valorTotal' => $valorProd, 'valorParcela' => $vlfor, 'discount' => $disc];
                //$product[$p['id']]['parcels'][$i] = "{$i}X de R$ {$vlfor} = R$ " . $valorProd . " {$disc_label} ";
            }

            $quantidade = $data['quantidade'];

            if ($produto->id == 34) {
                $valor_prod['valorTotal'] = 440;
                $valor_prod['valorCheio'] = 440;
                $valor_prod['valorParcela'] = 0;
                $valor_prod['discount'] = 0;
            } else {
                $valor_prod = $product[$produto->id]['parcels'][$data['parcelas']];
            }
            $totalpago = $valor_prod['valorTotal'] * $quantidade;

            $data_iugu = [
                "email" => $formando->email,
                'token' => $request->get('token'),
                "items[]" => [
                    "description" => $produto->name . " #" . $produto->id,
                    "quantity" => $quantidade,
                    "price_cents" => number_format($valor_prod['valorTotal'], 2, "", ""),
                ],
                "months" => $data['parcelas'],
            ];

            $iugu = new IuguService();
            $retorno = $iugu->pagarCartao($data_iugu);
            if (!isset($retorno->success)) {
                return redirect()->route('portal.comprasextras.comprar', ['produto' => $produto->id, 'quantidade' => $quantidade, 'dia_pagamento' => 10, 'tppg' => $data['tp_pg']]);
            }

            if (!$retorno->success) {
                $request->session()->flash("process_message", $retorno->message);
                $request->session()->flash("process_lr", $retorno->LR);
                return redirect()->route('portal.comprasextras.comprar', ['produto' => $produto->id, 'quantidade' => $quantidade, 'dia_pagamento' => 10, 'tppg' => $data['tp_pg']]);
            }

            $dataDB = [
                'forming_id' => $formando->id,
                'contract_id' => $contrato['id'],
                'name' => $produto->name,
                'description' => $produto->description,
                'img' => $produto->img,
                'value' => $valor,
                'discounts' => $valor_prod['discount'],
                'parcels' => $data['parcelas'],
                'payday' => date('d'),
                'termo_id' => $produto->termo_id,
                'amount' => $quantidade,
                'category_id' => $produto->category_id,
                'reset_igpm' => $produto->reset_igpm,
                'original_id' => $produto->id,
                'events_ids' => $produto->events_ids,
            ];
            $codFormandoProduto = FormandoProdutosEServicos::create($dataDB);

            foreach ($produto->categories_type as $cats) {
                FormandoProdutosEServicosCateriasTipos::create(['fps_id' => $codFormandoProduto->id, 'category_id' => $cats->category_id, 'quantity' => $cats->quantity]);
            }

            $parcela = FormandoProdutosParcelas::create(
                [
                    'formandos_produtos_id' => $codFormandoProduto->id,
                    'formandos_id' => $formando->id,
                    'contrato_id' => $formando->contract_id,
                    'dt_vencimento' => date("Y-m-d"),
                    'numero_parcela' => 1,
                    'valor' => $totalpago,
                    'status' => 1,
                ]
            );

            $pagamento = ParcelasPagamentos::create(['parcela_id' => $parcela->id, 'valor_pago' => $totalpago]);
            $dataInsert = [
                'parcela_pagamento_id' => $pagamento->id,
                'invoice_id' => $retorno->invoice_id,
                'payable_with' => 'credit_card',
                'secure_url' => $retorno->url,
            ];

            $pagamentoCartao = PagamentosCartao::create($dataInsert);

            $pagamento->typepaind()->associate($pagamentoCartao);
            $pagamento->save();

            $request->session()->flash("process_success_msg", $retorno->message);
            return redirect()->route('portal.extrato.produto', ['prod' => $codFormandoProduto->id]);
        } else {

            $serviceProdutos = new ProdutosService();
            $produtoIds[$produto->id] = $data['parcelas'];
            $prod = $serviceProdutos->cadastraProduto($produtoIds, $data['dia_pagamento'], date('Y-m-d H:i:s'), $formando->id, $contrato, $data['quantidade']);
            $prod_id = $prod->id;
            foreach ($produto->categories_type as $cats) {
                FormandoProdutosEServicosCateriasTipos::create(['fps_id' => $prod_id, 'category_id' => $cats->category_id, 'quantity' => $cats->quantity]);
            }
            AuditAndLog::createLog(Auth::user()->id, "Efetou Compra Extra: " . $prod->name . " - Quant.: {$prod->amount} - ID#{$prod->id}", 'null', Auth::user()->userable->contract_id);

            return redirect()->route('portal.extrato');
        }
    }

    public function albuns()
    {

        $forming = Forming::find(\auth()->user()->userable->id);
        $albuns = FormandoProdutosEServicos::where('forming_id', $forming->id)->where('category_id', '2')->get();

        if ($albuns->count() > 0) {

            return view('portal.albuns_comprado');
        } else {

            $contrato = Contract::find(\auth()->user()->userable->contract_id);
            $mes = DateHelper::ConvertMonth($contrato->conclusion_month);
            $products = ProductAndService::where('contract_id', $contrato->id)->where(
                'category_id',
                2
            )->get()->toArray();

            foreach ($products as $p) {

                $product[$p['id']] = $p;

                $values = ProductAndServiceValues::where('products_and_services_id', $p['id'])
                    ->where('date_start', '<=', date('Y-m-d H:i:s'))
                    ->where('date_end', '>', date('Y-m-d H:i:s'))
                    ->get()->first();
                    
                if($values){
                    $values = $values->toArray();
                }


                $product[$p['id']]['values'] = $values;
                $product[$p['id']]['termo'] = ProdutosEServicosTermo::where(
                    'id',
                    '=',
                    $p['termo_id']
                )->get()->toArray()[0];
                $product[$p['id']]['termo'] = str_replace(
                    '[[=valor]]',
                    number_format($product[$p['id']]['values']['value'], 2, ',', '.'),
                    $product[$p['id']]['termo']
                );

                $discounts = ProductAndServiceDiscounts::where('products_and_services_id', $p['id'])
                    ->where('date_start', '<=', date('Y-m-d H:i:s'))
                    ->where('date_end', '>', date('Y-m-d H:i:s'))
                    ->get()->toArray();

                foreach ($discounts as $d) {
                    $product[$p['id']]['discounts'][$d['maximum_parcels']] = $d;
                }

                $product[$p['id']]['max_parcels'] = ConvertData::calculaParcelasMeses(
                    date(
                        'Y-m-d',
                        strtotime($product[$p['id']]['values']['date_start'])
                    ),
                    $product[$p['id']]['values']['maximum_parcels']
                );

                //$product[$p['id']]['discounts'] = $discounts;

            }
            if (count($products) <= 0) {
                return view('portal.albuns', ['product' => null]);
            }

            return view('portal.albuns', ['product' => $product]);
        }
    }

    public function albunsComprar(ProductAndService $produto, $quantidade, $dia_pagamento)
    {
        $product['product'] = $produto;
        $values = ProductAndServiceValues::where('products_and_services_id', $produto->id)
            ->where('date_start', '<=', date('Y-m-d H:i:s'))
            ->where('date_end', '>', date('Y-m-d H:i:s'))
            ->get()->first();
        
        if($values){
            $values = $values->toArray();
        }

        $product['values'] = $values;
        $product['termo'] = ProdutosEServicosTermo::where('id', '=', $product['product']['termo_id'])->get()->toArray()[0];
        $product['termo'] = str_replace('[[=valor]]', number_format($product['values']['value'], 2, ',', '.'), $product['termo']);

        $discounts = ProductAndServiceDiscounts::where('products_and_services_id', $produto->id)
            ->where('date_start', '<=', date('Y-m-d H:i:s'))
            ->where('date_end', '>', date('Y-m-d H:i:s'))
            ->get()->toArray();

        foreach ($discounts as $d) {
            $product['discounts'][$d['maximum_parcels']] = $d;
        }
        $product['limiteQt'] = 1;
        $date_inicio = date('Y-m-d', strtotime($product['values']['date_start']));
        $maximum_parcls = $product['values']['maximum_parcels'];
        $product['max_parcels'] = ConvertData::calculaParcelasMeses($date_inicio, $product['values']['maximum_parcels']);
        $max_parls = ConvertData::geraParcelasProdutos($date_inicio, $maximum_parcls, $dia_pagamento);
        $valor = ($product['values']['value'] * $quantidade);
        for ($i = 1; $i <= $max_parls; $i++) {

            $disc = 0;
            if (isset($product['discounts']) and is_array($product['discounts'])) {

                $discounts_array = $product['discounts'];
                //dd($discounts_array);
                krsort($discounts_array);
                //dd($discounts_array);
                foreach ($discounts_array as $k => $v) {
                    if ($v['maximum_parcels'] >= $i) {
                        $disc = $v['value'];
                    }
                }
            }

            $valorProd = ($valor - ($valor * ($disc / 100)));
            $vl_parcela = ($valorProd / $i);
            $vlfor = number_format($vl_parcela, 2, ',', '.');
            $disc_label = ($disc > 0 ? "C/ {$disc}% de desconto" : "");
            $product['parcels'][$i] = "{$i}X de R$ {$vlfor} = R$ " . number_format($valorProd, 2, ",", '.') . " {$disc_label} ";
        }
        foreach ($product['max_parcels'] as $parcela) {
            $product['selectDiaPagamento'][date("d", strtotime($parcela['priPagamento']))] = date("d/m/Y", strtotime($parcela['priPagamento']));
        }

        $estoque = 30;
        $estoque = ($estoque > 15) ? 15 : $estoque;
        for ($i = 1; $i <= $estoque; $i++) {
            $selectQuantidade[$i] = $i;
        }
        $product['selectQuantidade'] = $selectQuantidade;
        return view('portal.albuns_comprar', ['product' => $product, 'quantidade' => $quantidade, 'dia_pagamento' => $dia_pagamento]);
    }

    public function albunsStore(Request $request)
    {
        $data = $request->all();
        
        $produto = ProductAndService::where('id', $data['prodId'])->get()->toArray();
        $formando = \auth()->user()->userable->id;
        $contrato['id'] = \auth()->user()->userable->contract_id;
        $serviceProdutos = new ProdutosService();
        $produtoIds[$produto[0]['id']] = $data['parcelas'];
        $prod = $serviceProdutos->cadastraProduto($produtoIds, $data['dia_pagamento'], date('Y-m-d H:i:s'), $formando, $contrato, $data['quantidade']);        
        AuditAndLog::createLog(Auth::user()->id, "Efetou Compra Extra: " . $prod->name . " - Quant.: {$prod->amount} - ID#{$prod->id}", 'null', Auth::user()->userable->contract_id);
        //dd(\Route::current()->getName());
        return $this->extrato();
        //return redirect()->route('portal.extrato');
    }

    public function termoPdf(FormandoProdutosEServicos $product)
    {

        $termo = ProdutosEServicosTermo::find($product->termo_id);

        $content = str_replace('[[=valor]]', number_format($product->valorFinal(), 2, ',', '.'), $termo->conteudo);

        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML('
            <meta charset="UTF-8">
            <title>' . $termo->titulo . '</title>'
            . $content);

        AuditAndLog::createLog(Auth::user()->id, "Imprimiu Termo: " . $termo->titulo, 'null', Auth::user()->userable->contract_id);
        return $pdf->stream();
    }

    public function mmvantagem()
    {
        return view('portal.mmvantagem');
    }

    public function raffle(Raffle $raffle, RaffleServices $raffleServices)
    {
        $forming = Auth::user()->userable;
        if ($forming->contract_id != 1) {
            return redirect()->back();
        }
        $forming_raffle_numbers = RaffleNumbers::where('raffle_id', $raffle->id)->where('forming_id', $forming->id)->get();
        $quant_numbers = $forming_raffle_numbers->count();

        if ($quant_numbers < $raffle->numbers_per_person) {
            $for = $raffle->numbers_per_person - $quant_numbers;
            $raffleServices->generateNumbers($for, $forming, $raffle);
            $forming_raffle_numbers = RaffleNumbers::where('raffle_id', $raffle->id)->where('forming_id', $forming->id)->get();
        }
        return view('portal.raffles', compact('forming', 'raffle', 'forming_raffle_numbers'));
        //dd($quant_numbers);
        //$raffleServices->generateNumbers(100, $forming, $raffle);
        //dd($formando);

    }

    public function raffleSelect(Request $request)
    {
        $raffles = Raffle::where('status', 1)->get();
        return view('portal.raffles-select', compact('raffles'));
    }

    public function raffleNumberUpdate(RaffleNumbers $number)
    {
        $forming = Auth::user()->userable;
        if ($forming->contract_id != 1) {
            return redirect()->back();
        }
        $raffle = Raffle::where('draw_date', '>=', date('Y-m-d'))->where('status', 1)->first();
        $raffle_numbers = $number;

        return view('portal.rafflenumberupdate', compact('forming', 'raffle', 'raffle_numbers'));
    }

    public function raffleNumberUpStore(RaffleNumbers $number, Request $request)
    {
        
        $this->validate($request, [
            "buyer_name" => "required",
            "buyer_email" => "required|email",
        ]);

        $dataForm = $request->all();
        $dataForm['purchase_date'] = date("Y-m-d");
        unset($dataForm['_token']);
        $number->update($dataForm);
        $raffle = Raffle::where('draw_date', '>=', date('Y-m-d'))->where('status', 1)->first();
        //dd($raffle->id);
        $this->imgRafflePress($raffle, $number);

        Mail::to($number->buyer_email)->send(new RaffleMail($number));
        return redirect()->route('portal.raffle',[$raffle->id]);
    }

    public function raffleNumberView(RaffleNumbers $number)
    {
        $forming = Auth::user()->userable;
        if ($forming->contract_id != 1) {
            return redirect()->back();
        }
        $raffle = $number->raffle;
        $raffle_numbers = $number;
        
        /*if(!is_dir(public_path('img/portal/raffles'))){
            mkdir(public_path('img/portal/raffles'));
        }*/
        $imgUrl = public_path('img/portal/raffles') . '/' . $raffle_numbers->img;

        if (is_file($imgUrl)) {
            $img = $raffle_numbers->img;
        } else {

            $img = $this->imgRafflePress($raffle, $raffle_numbers);
        }

        $url = asset('img/portal/raffles/' . $img);

        return view('portal.rafflenumberview', compact('forming', 'raffle', 'raffle_numbers', 'url'));
    }

    public function raffleNumberPrint(RaffleNumbers $number)
    {

        $forming = Auth::user()->userable;
        $raffle = Raffle::where('draw_date', '>=', date('Y-m-d'))->where('status', 1)->first();
        $raffle_numbers = $number;
        $imgUrl = public_path('img/portal/raffles') . '/' . $raffle_numbers->img;

        if (is_file($imgUrl)) {
            $img = $raffle_numbers->img;
        } else {
            $img = $this->imgRafflePress($raffle, $raffle_numbers);
        }

        $url = asset('img/portal/raffles/' . $img);

        return view('portal.rafflenumberprint', compact('url'));
    }

    public function raffleNumberHash(Request $request, $hash)
    {
        $raffle_numbers = RaffleNumbers::where('hash', $hash)->first();
        if (!$raffle_numbers) {
            return view('portal.rafflenumberhashfail');
        }

        $url = asset('img/portal/raffles') . '/' . $raffle_numbers->img;
        return view('portal.rafflenumberhash', compact('url', 'raffle_numbers'));
    }

    public function ticketSave($code)
    {
        $ticket = Ticket::where('code', $code)->where('status', 1)->first();
        $forming_id = \auth()->user()->userable->id;
        if (!$ticket or ($ticket->forming_id != $forming_id)) {
            return redirect()->route('erro.404');
        }

        $pdf = \App::make('dompdf.wrapper');
        $img = $ticket->id . '.png';
        $customPaper = array(0, 0, 480, 256);
        $logoimini = '/public/img/logo_i_mini.png';

        QrCode::format('png')->merge($logoimini)->size(300)->margin(1)->errorCorrection('H')->generate($ticket->code, '../public/qrcodes/' . $img . '');
        $logo = asset('img/logo.png');
        $pdf->loadView('portal.components.ticketPDF', compact('logo', 'logoimini', 'img', 'ticket'))->setPaper($customPaper, 'landscape');
        $stream = $pdf->stream('ticket_' . $ticket->id . '.pdf');
        unlink('../public/qrcodes/' . $img);
        return $stream;
    }

    private function imgRafflePress(Raffle $raffle, RaffleNumbers $raffle_numbers)
    {

        $img = asset('img/portal/' . $raffle->img);
        
        $img_name = $raffle->id . '_' . $raffle_numbers->number;
        $image = Image::make($img)
            ->resize(800, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            
        $image->text(str_pad($raffle_numbers->number, 5, '0', STR_PAD_LEFT), 480, 260, function ($font) {
            $font->file(public_path('assets/common/fonts/arial.ttf'));
            $font->size(22);
            $font->color('#000');
        });
        $image->text(number_format($raffle->price, 2, ",", "."), 630, 260, function ($font) {
            $font->file(public_path('assets/common/fonts/arial.ttf'));
            $font->size(22);
            $font->color('#000');
        });
        $image->text(str_limit($raffle_numbers->buyer_name, $limit = 24, $end = '.'), 30, 70, function ($font) {
            $font->file(public_path('assets/common/fonts/arial.ttf'));
            $font->size(19);
            $font->color('#000');
        });
        $image->text($raffle_numbers->buyer_phone, 30, 240, function ($font) {
            $font->file(public_path('assets/common/fonts/arial.ttf'));
            $font->size(19);
            $font->color('#000');
        });
        $image->text(str_limit($raffle_numbers->buyer_email, $limit = 40, $end = '.'), 30, 150, function ($font) {
            $font->file(public_path('assets/common/fonts/arial.ttf'));
            $font->size(12);
            $font->color('#000');
        });
        $image->text($raffle->premium, 500, 120, function ($font) {
            $font->file(public_path('assets/common/fonts/arial.ttf'));
            $font->size(34);
            $font->color('#000');
        });
        $image->text(date("d/m/Y", strtotime($raffle->draw_date)), 500, 215, function ($font) {
            $font->file(public_path('assets/common/fonts/arial.ttf'));
            $font->size(22);
            $font->color('#000');
        });
        $image->encode('png');
        
        if (!is_dir(public_path('img/portal/raffles/'))) {
            mkdir(public_path('img/portal/raffles/'), 0777, true);            
        }
        $image->save(public_path('img/portal/raffles/' . $img_name . '.png'), 100);
        $raffle_numbers->img = $image->basename;
        $raffle_numbers->save();
        return $image->basename;
    }

    public function identify()
    {
        $formando = \auth()->user()->userable;
        return view('portal.identify', compact('formando'));
    }

    public function gifts()
    {

        $contrato = Contract::find(\auth()->user()->userable->contract_id);
        $gifts = Gift::where('status', 1)->where('contract_id', $contrato->id)->get();

        $arrays_cart = [];
        if (session('gifts.checkout')) {
            foreach (session('gifts.checkout') as $s) {
                $arrays_cart[] = $s->id;
            }
        }

        return view('portal.gifts', ['gifts' => $gifts, 'arrays_cart' => $arrays_cart]);
    }

    public function giftdetails(Request $request)
    {
        $formando = Auth::user()->userable;
        $giftId = $request->get('gift');
        $gift = Gift::where('id', $giftId)->where('status', 1)->where('contract_id', $formando->contract_id)->first();

        $arrays_cart = [];
        if (session('gifts.checkout')) {
            foreach (session('gifts.checkout') as $s) {
                $arrays_cart[] = $s->id;
            }
        }

        return view('portal.gift_details', compact('gift', 'arrays_cart'));
    }

    public function giftscheckout(Request $request)
    {

        $delGift = $request->get('del');
        if (isset($delGift) && $delGift > 0) {

            $session_temp = $request->session()->get('gifts.checkout');
            $request->session()->forget('gifts.checkout');
            foreach ($session_temp as $session) {
                if ($delGift != $session->id) {
                    $request->session()->push('gifts.checkout', $session);
                }
            }
            $request->session()->save();
        }

        $giftId = $request->get('gift');
        $msg = '';
        if (isset($giftId) && $giftId > 0) {

            $findInCheckout = false;
            if ($request->session()->get('gifts.checkout')) {

                foreach ($request->session()->get('gifts.checkout') as $session) {
                    if ($session->id == $giftId) {
                        $findInCheckout = true;
                    }
                }
            }

            if ($findInCheckout) {
                $msg = 'Produto já existe no carrinho';
            } else {
                $gift = Gift::find($giftId);
                $request->session()->push('gifts.checkout', $gift);
                $request->session()->save();
            }
            $request->session()->flash('add', 'PRODUTO ADICIONADO AO CARRINHO');
        }

        return view('portal.giftscheckout', compact('msg'));
    }

    public function giftspaysession(Request $request)
    {
        $prods = $request->get('prod');

        foreach ($prods as $p) {

            $ptemp = Gift::find($p['id']);
            $subtotal = $ptemp->price * $p['amount'];

            $prod[$p['id']] = [
                'id' => $p['id'],
                'name' => $ptemp->name,
                'photo' => $ptemp->photo,
                'description' => $ptemp->description,
                'amount' => $p['amount'],
                'size' => $p['size'],
                'models' => $p['models'],
                'price' => $ptemp->price,
                'subtotal' => $subtotal,
            ];
        }
        $request->session()->put('gifts.payment', $prod);
        $request->session()->save();

        return redirect()->route('portal.gifts.payment');
    }

    public function giftspayment(Request $request)
    {
        $payment = [];
        $payment['count'] = 0;
        $payment['subtotal'] = 0;
        foreach (session('gifts.payment') as $p) {
            $payment['count'] += 1;
            $payment['subtotal'] += $p['subtotal'];
        }
        $free = ($payment['subtotal'] == 0 && $payment['count'] > 0) ? true : false;
        return view('portal.giftspayment', compact('free'));
    }

    public function giftsPayCreditProcess(Request $request)
    {

        $payment = [];
        $payment['count'] = 0;
        $payment['subtotal'] = 0;

        $formando = Auth::user()->userable;
        $user_id = Auth::user()->id;
        $total = 0;
        foreach (session('gifts.payment') as $prod) {
            $total += $prod['amount'] * $prod['price'];
            $items[] = [
                "description" => $prod['name'],
                "quantity" => $prod['amount'],
                "price_cents" => number_format($prod['price'], 2, "", ""),
            ];
            $payment['count'] += 1;
            $payment['subtotal'] += $prod['subtotal'];
        }
        $free = ($payment['subtotal'] == 0 && $payment['count'] > 0) ? true : false;
        if (!$free) {

            $data = [
                "items" => $items,
                "email" => $formando->email,
                'token' => $request->get('token-iugu'),
                "months" => $request->get('pay-parcels'),
            ];

            //dump(json_encode($data), $request->get('token-iugu'));
            //dd('ok');

            $iugu = new IuguService();
            $retorno = $iugu->IuguCredit($data);
            if (!isset($retorno['success'])) {
                $request->session()->flash("process_message", $retorno['message']);
                $request->session()->flash("process_lr", $retorno['LR']);
                return redirect()->route("portal.gifts.payment");
            }

            if (!$retorno['success']) {
                $request->session()->flash("process_message", $retorno['message']);
                $request->session()->flash("process_lr", $retorno['LR']);
                return redirect()->route("portal.gifts.payment");
            }
            $parcels = $request->get('pay-parcels');
            $msg = $retorno->message;
        } else {
            $retorno['invoice_id'] = 'free';
            $retorno['pdf'] = '';
            $parcels = 0;
            $msg = "Pedido realizado com sucesso!";
        }

        $dataGiftRequests = [
            'contract_id' => $formando->contract_id,
            'forming_id' => $formando->id,
            'total' => $total,
            'payment_parcels' => $parcels,
            'payment_id' => $retorno['invoice_id'],
            'pdf' => $retorno['pdf'],
            'status' => 2,
        ];

        $giftRequests = GiftRequests::create($dataGiftRequests);

        foreach (session('gifts.payment') as $prod) {

            $prodData = $prod;
            unset($prodData['subtotal']);
            $prodData['model'] = $prodData['models'];
            unset($prodData['models']);
            $prodData['request_id'] = $giftRequests['id'];
            $prodData['original_id'] = $prodData['id'];
            unset($prodData['id']);

            GiftRequestsGifts::create($prodData);
        }

        $giftRequests->statusHistoric()->create(['giftrequest_id' => $giftRequests->id, 'user_id' => $user_id, 'status' => 1]);
        $giftRequests->statusHistoric()->create(['giftrequest_id' => $giftRequests->id, 'user_id' => $user_id, 'status' => 2]);

        $request->session()->forget('gifts.checkout');
        $request->session()->flash("process_success_msg", $msg);
        return redirect()->route("portal.gift.requests");
    }

    public function giftrequest($id)
    {
        $formando = Auth::user()->userable;
        $requestId = $id;
        $request = GiftRequests::where('id', $requestId)->where('status', '>=', 1)->where('forming_id', $formando->id)->first();

        return view('portal.gift_request', compact('request'));
    }

    public function giftrequests()
    {
        $formando = Auth::user()->userable;
        $requests = GiftRequests::where('status', '>=', 1)->where('forming_id', $formando->id)->orderBy('created_at', 'desc')->get();

        return view('portal.gift_requests', compact('requests'));
    }

    public function surveys()
    {
        $formando = \auth()->user()->userable;
        $surveys = Survey::where(['contract_id' => $formando->contract_id, 'status' => 1])->get();
        return view('portal.enquete.index', compact('surveys'));
    }

    public function surveyShow(Survey $survey)
    {

        $formando = \auth()->user()->userable;
        $answer = SurveyAnswer::where([
            'forming_id' => $formando->id,
            'survey_id' => $survey->id,
        ])->first();
        return view('portal.enquete.show', compact('survey', 'answer'));
    }

    public function surveyAnswerStore(Survey $survey, Request $request)
    {
        $formando = \auth()->user()->userable;
        $answerId = $request->get('question');
        $answer = SurveyAnswer::create([
            'forming_id' => $formando->id,
            'survey_id' => $survey->id,
            'survey_questions_id' => $answerId,
        ]);
        session()->flash('msg', 'Resposta registrada com sucesso!');
        return redirect()->route('portal.survey.index');
    }

    public function extratoProdutoPayCredit2(FormandoProdutosEServicos $prod, PagSeguroService $pseg)
    {

        if ($prod->forming_id != \auth()->user()->userable->id) {
            return redirect()->route('erro.404');
        }
        $parcelas = FormandoProdutosParcelas::where('formandos_produtos_id', $prod->id)->get()->toArray();

        $pagamentos = [];
        foreach ($parcelas as $parcela) {
            $ret = ParcelasPagamentos::where('parcela_id', $parcela['id'])->where('deleted', 0)->first();
            if ($ret) {
                $pagamentos[$parcela['id']] = $ret;
            }
        }

        $valor_pago = 0;
        $parcels = FormandoProdutosParcelas::where('formandos_produtos_id', $prod->id)->where('dt_vencimento', '<', date('Y-m-d'))->get();
        $valor = $parcels->sum('valor');

        foreach ($parcels as $parcel) {
            if (isset($parcel->pagamento)) {
                $sum_pag = $parcel->pagamento->sum('valor_pago');
                $valor_pago += $sum_pag;
            }
        }

        $valor_pago_p = 0;
        $parcels_pago = FormandoProdutosParcelas::where('formandos_produtos_id', $prod->id)->get();
        $sum_pags = [];
        foreach ($parcels_pago as $parcel_p) {
            if (isset($parcel_p->pagamento) && $parcel_p['status']) {
                $sum_pag = $parcel_p->pagamento->sum('valor_pago');
                $valor_pago_p += $sum_pag;
                if ($sum_pag <= 0) {
                    $sum_pags[] = $parcel_p->id;
                }
            }
        }

        if ($valor_pago_p <= 0) {
            $prod_status = 'Pendente';
        } elseif ($valor_pago_p >= 0 and ($valor_pago_p >= $valor)) {
            $prod_status = 'Adimplente';
        } elseif ($valor_pago_p >= 0 and ($valor_pago_p < $valor)) {
            $prod_status = 'Inadimplente';
        }

        $saldo_pagar = ($prod->valorFinal() - $valor_pago_p);

        $date = Carbon::now();
        $dateLimit = Carbon::now();
        $dateLimit->addDays(40);

        //dd($valor_pago, $valor);

        $produtos = $prod->get()->toArray();

        $parcels_max = FormandoProdutosParcelas::where('formandos_produtos_id', $prod->id)->where('dt_vencimento', '>=', date('Y-m-d'))->get();
        $parce_max = $parcels_max->count();
        $parce_max = ($parce_max > 12) ? 12 : $parce_max;
        $parce_max = ($parce_max <= 0) ? 1 : $parce_max;
        $id_sessao = $pseg->geraSessao();
        //Alert::error('Ops!', 'oi');
        AuditAndLog::createLog(Auth::user()->id, 'Acessou Extrato Produtos: ' . $prod->name . ' - ID#' . $prod->id, 'null', Auth::user()->userable->contract_id);
       
        $dados_contrato = Contract::find(Auth::user()->userable->contract_id);

        $tipo_pagamento = $dados_contrato->tipo_pagamento;
       
        return view('portal.extrato_produto_payment', compact('prod', 'parcelas', 'pagamentos', 'prod_status', 'date', 'dateLimit', 'saldo_pagar', 'valor_pago_p', 'parce_max', 'sum_pags', 'id_sessao','tipo_pagamento'));
    }

    public function consultaAtivaBoleto(PagSeguroService $pseg){

       //query de boletos a serem verificados 
        $boletos_pendentes = PagamentosBoleto::where('due_date','>','2021-02-20')->get();
        //


        $contrato_id = 3; 
        
        //varrendo todos os boletos
        foreach ($boletos_pendentes as $key => $value) {

            //realizando consulta da transação
            $transaction = $pseg->consultarTransacao($value->invoice_id,$contrato_id);
            //guardando status da transação
            $status_trn = $pseg->cod_status($transaction->status);
            //data da transação
            $date = new DateTime($transaction->date);
            //data do pagamento
            $paid_at = new DateTime($transaction->lastEventDate);

           //verificando a existencia da transaction->referncia
            if( isset($transaction->reference) ){
                $parcela = FormandoProdutosParcelas::find($transaction->reference);
            }else{
                dd($transaction->reference. 'trn nao encontrada');
            }
            //se não houver parcela 
            if (!isset($parcela)) {
                dd($parcela.'pagamento não entrando');
            }

            //se houver um status da transação guardar a descrição do status, o tipo de pagamento a data da transação e a data do pagamento
            if (isset($transaction->status)) {
                $status_trn = $pseg->cod_status($transaction->status);
                $tipo_pagamento = $pseg->tipo_pagamento($transaction->paymentMethod->type);
                $date = new DateTime($transaction->date);
                $paid_at = new DateTime($transaction->lastEventDate);
            } else {
                dd($transaction.'não encontrada na verificação de status');
            }

            //se o status for recusado
            if ($status_trn == 'Recusado') {

                //update no status da parcela FormandoProdutosParcelas 
                $parcela->update(['status' => 0]);
                $pagamento = ParcelasPagamentos::where('parcela_id', $parcela->id)->first();
    
               //update para deleted 1 (cancelado ou recusado)
                $pagamento->update(['valor_pago' => 0, 'deleted' => 1]);
  
                $pgBoleto = PagamentosBoleto::where('parcela_pagamento_id', $pagamento->id)->first();  
                $data = [
                    'status' => $status_trn,
                    // 'deleted' => 1,
                ];
    
               try {
                
               

                $pgBoleto->update($data);
                   
                $pgBoleto->parcelaPagamento->update(['deleted' => 1]);
    
                
               } catch (\Throwable $th) {
                 
                   dd($pgBoleto);
               }
               
               
    
                // echo $deleteBoleto;
                // echo $deleteParcelaPagamento;
               
            }       


            // se o status for pago
            if ($status_trn == 'Pago') {

                //update no status da parcela
                $parcela->update(['status' => 1]);
                $pagamento = ParcelasPagamentos::where('parcela_id', $parcela->id)->first();
    
                if (!$pagamento) {
                    $pagamento = ParcelasPagamentos::create(['parcela_id' => $parcela->id, 'valor_pago' => $transaction->grossAmount]);
                } else {
                    $pagamento->update(['valor_pago' => ($transaction->grossAmount), 'deleted' => 0]);
                }
    
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
            }       
         
            
        }

    
    }

    public function consultaTransacao(PagSeguroService $pseg, $invoice_id){
        $contrato_id=3;
        $transaction = $pseg->consultarTransacao($invoice_id,$contrato_id);
        dd($transaction);

    }


}
