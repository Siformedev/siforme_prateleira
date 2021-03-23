@extends('portal.inc.layout')

@section('content')

<section class="page-content">
    <div class="page-content-inner">

        @if(Session::has('process_message'))
        <div class="alert alert-danger">{{Session::get('process_message')}}! Código:
            LR-{{Session::get('process_lr')}}</div>
        @endif

        @if(Session::has('process_success_msg'))
        <div class="alert alert-success">Pagamento {{Session::get('process_success_msg')}}!</div>
        @endif

        <section class="panel">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-lg-2 col-md-3 col-sm-3"><a class="btn btn-default"
                            href="{{route('portal.extrato')}}">Voltar</a> </div>
                    <div class="col-lg-10 col-md-9 col-sm-9">
                        <h3>{{$prod['name']}}</h3>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-2 col-md-3 col-sm-12">
                        <img src="{{$prod['img']}}" style="width: 100px; height: auto;">
                    </div>
                    <div class="col-lg-10 col-md-9 col-sm-12">
                        <b>Descrição:</b> <br>
                        {{$prod['description']}}
                        @if($prod['withdrawn'] > 0)
                        <br><span class="label label-warning font-size-18"
                            style="padding: 10px; margin-top: 10px;">Retirado {{ $prod['withdrawn'] }} convite
                            (s)</span>
                        @endif
                        <!--
                            <div class="row">
                                <div class="col-md-12">
                                    <hr>
                                    <span>Percentual já Pago (75%)</span>
                                    <progress class="progress progress-success progress-striped" value="75" max="100">75%</progress>
                                </div>
                            </div>
                            -->
                    </div>

                </div>

                <hr>

                <h3>Dados do Pedido</h3>

                <div class="row">
                    <div class="col-md-12" style="font-size: 16px;">
                        <table class="table table-bordered">
                            <tr>
                                <th scope="row">Codigo:</th>
                                <td>#{{str_pad($prod['id'], 8, '0', STR_PAD_LEFT)}}</td>
                            </tr>
                            <tr>
                                <th scope="row">Data do pedido:</th>
                                <td>{{Carbon\Carbon::parse($prod['created_at'])->format('d/m/Y')}}</td>
                            </tr>
                            <tr>
                                <th scope="row">Valor:</th>
                                <td>R$ {{number_format($prod->valorFinal(),2,",", ".")}}</td>
                            </tr>
                            <tr>
                                <th scope="row">Quantidade:</th>
                                <td>{{number_format($prod['amount'],0)}}</td>
                            </tr>
                            <tr>
                                <th scope="row">Dia Pagamento:</th>
                                <td>{{$prod['payday']}}</td>
                            </tr>
                            <tr>
                                <th scope="row">Próximo Reajuste IGPM
                                    <button type="button" class="btn btn-default-outlined margin-inline"
                                        data-toggle="tooltip" data-placement="top" title=""
                                        data-original-title="Correção monetária que acontece de 12 em 12 meses">
                                        ?
                                    </button>
                                    <script>
                                        $(function () {

                                                $("[data-toggle=popover]").popover();
                                                $("[data-toggle=popover-hover]").popover({
                                                    trigger: 'hover'
                                                });

                                                $("[data-toggle=tooltip]").tooltip();

                                            });

                                    </script>
                                    :
                                </th>
                                @if(!empty($prod['reset_igpm']))
                                <td>{{Carbon\Carbon::parse($prod['reset_igpm'])->format('d/m/Y')}}</td>
                                @else
                                <td>Não se aplica</td>
                                @endif
                            </tr>
                            <tr>
                                <th scope="row">Status</th>
                                <td>{{$prod_status}}</td>
                            </tr>
                            <tr class="">
                                <th scope="row">TERMO DE ADESÃO</th>
                                <td><a href="{{route('portal.termo.pdf', ['product' => $prod['id']])}}"
                                        class="btn btn-success" target="_blank">Imprimir</a></td>
                            </tr>
                        </table>
                    </div>
                </div>

                <hr>
                @if (false)


                <h3>Parcelas</h3>

                <div class="row">
                    <div class="col-md-12" style="font-size: 16px;">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="text-center">Vencimento</th>
                                    <th class="text-center">Valor</th>
                                    <th class="text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($parcelas as $parcela)
                                <?php
                                //dd($parcelas);
                                //dd($pagamentos);
                                    $actionParc = '';
                                    $sumpg = 0;
                                    $tptype = '';
                                    //dd($parcelas);
                                    if(isset($pagamentos[$parcela['id']]) ){

                                        $parc = $pagamentos[$parcela['id']];
                                        $sumpg = $parc->valor_pago;
                                        if(isset($parc->typepaind_type)){
                                            $tptype = $parc->typepaind_type;
                                            $credit_parcels = isset($parc->typepaind->installments)?$parc->typepaind->installments:'';
                                            $credit_link_pdf = isset($parc->typepaind->secure_url)?$parc->typepaind->secure_url:'';
                                        }else{
                                            $tptype = null;
                                        }

                                    }

                                    
                                    if($sumpg >= $parcela['valor'] && $parcela['status']){

                                        if($tptype == ''){
                                            $actionParc = '<span class="label label-success">PAGO</span>';
                                        }elseif($tptype == 'App\PagamentosBoleto'){
                                            $actionParc = '<span class="label label-success">PAGO</span>';
                                        }elseif($tptype == 'App\PagamentosCartao'){
                                            $credit_parcels = ($credit_parcels <= 0) ? 1 : $credit_parcels;
                                            $actionParc = '<span style="height: 30px; " class="label label-success">PAGO</span> <a target="_blank" href="'.$credit_link_pdf.'.pdf"> <img style="height: 60px;" src="'.asset('img/pay_credit_X'.$credit_parcels.'.png').'"></a>';
                                        }


                                    }elseif($sumpg <= 0 ){
                                        //dd($parc);
                                        //var_dump($parc->typepaind_type);
                                        if(date('Y-m-d', strtotime($parcela['dt_vencimento'])) <= $dateLimit->format('Y-m-d')){
                                            if(date('Y-m-d', strtotime($parcela['dt_vencimento'])) < date('Y-m-d')){
                                                //$actionParc = '<span class="label label-warning" title="Seu boleto estará disponível 5 dias antes do vencimento" target="_blank">Emitindo seu boleto...</span>';
                                                $actionParc = '<a href="'.route('portal.formando.boleto',['parcela' => $parcela['id']]).'" class="label label-danger" target="_blank">Vencida</a>';
                                            }
                                            elseif( isset($parc->typepaind_type) && $parc->typepaind_type == 'App\PagamentosCartao'){
                                                
                                            if($pgto['status'] == 'Recusado'){
                                                $actionParc = '<a  class="label label-danger" target="_blank"> Cartão '.$pgto['status'].' </a>';
                                            }else{
                                                $actionParc = '<a  class="label label-warning" target="_blank"> Cartão '.$pgto['status'].' </a>';
                                                $disable_cc_pgto = true;
                                            }
                                                    
                                        }else{
                                            
                                                $actionParc = '<a href_javascript="'.route('portal.formando.boleto',['parcela' => $parcela['id']]).'" class="label label-warning boleto-imprimir" target="_blank">Imprimir</a>';
                                                //$actionParc = '<span class="label label-warning" title="Seu boleto estará disponível 5 dias antes do vencimento" target="_blank">Emitindo seu boleto...</span>';
                                            }
                                        }else{
                                            if(date('Y-m-d', strtotime($parcela['dt_vencimento'])) < date('Y-m-d')){
                                                //$actionParc = '<span class="label label-warning" title="Seu boleto estará disponível 5 dias antes do vencimento" target="_blank">Emitindo seu boleto...</span>';
                                                $actionParc = '<a href="'.route('portal.formando.boleto',['parcela' => $parcela['id']]).'" class="label label-danger" target="_blank">Vencida</a>';
                                            }else{
                                                $actionParc = '<span class="label label-primary a-vencer-click" title="Seu boleto estará disponível 30 dias antes do vencimento" style="cursor: pointer ;">A Vencer</span>';
                                            }

                                        }
                                    }


                                    ?>
                                <tr>
                                    <td class="text-center">{{$parcela['numero_parcela']}}</td>
                                    <td class="text-center">{{date('d/m/Y', strtotime($parcela['dt_vencimento']))}}</td>
                                    <td class="text-center">{{number_format($parcela['valor'],2, ",", ".")}}</td>
                                    <td class="text-center"> {!! $actionParc !!} </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>


            </div>
            <div class="panel-footer">



            </div>


        </section>

        @if(count($events_array)>0)

        <section class="panel">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-lg-8 col-md-7 col-sm-7">
                        <h3>Ingressos</h3>
                    </div>
                </div>
            </div>
            @foreach($events_array as $e)


            <div style="padding: 10px;">


                <div class="panel-group accordion accordion-margin-bottom" id="accordion2" role="tablist"
                    aria-multiselectable="true">
                    <div class="panel panel-default">
                        <div class="panel-heading collapsed" role="tab" id="headingOne2" data-toggle="collapse"
                            data-parent="#accordion2" data-target="#collapseOne2" aria-expanded="false"
                            aria-controls="collapseOne2">
                            <div class="panel-title">
                                <span class="accordion-indicator pull-right">
                                    <i class="plus fa fa-plus"></i>
                                    <i class="minus fa fa-minus"></i>
                                </span>
                                <a>
                                    <h5>{{$e['event']->name}} - {{date("d/m/Y - H:i", strtotime($e['event']->date))}}
                                    </h5>
                                </a>
                            </div>
                        </div>
                        <div id="collapseOne2" class="panel-collapse collapse" role="tabpanel"
                            aria-labelledby="headingOne2" aria-expanded="false" style="height: 0px;">
                            <div class="panel-body" style="padding: 0">
                                <div class="panel-body" style="height: 530px; overflow: auto">
                                    @foreach($e['tickets'] as $t)

                                    @include('portal.components.ticket')

                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach

        </section>
        @endif

        <section class="panel">
            <div class="panel-heading">

                <div class="row">

                    <div class="col-lg-8 col-md-7 col-sm-7">
                        <h3>Resumo / Saldo</h3>
                    </div>
                    @if($saldo_pagar > 0 && isset($disable_cc_pgto) && !$disable_cc_pgto)
                    @if(auth()->user()->userable->contract_id == 7)
                    <div class="col-lg-4 col-md-5 col-sm-5"><a class="btn btn-info"
                            onclick="alert('Paga pagamento com cartão, favor entre em contato através do email: contato@arrecadeei.com.br')">PAGAR
                            SALDO COM CARTÃO DE CRÉDITO</a> </div>
                    @else


                    <div class="col-lg-4 col-md-5 col-sm-5 btn-group-vertical ">
                        {{-- <a href_javascript="{{route('portal.formando.boleto',['parcela' => $parcela['id']])}}"
                        class="btn btn-warning btn-block p-3 boleto-imprimir" style="margin-bottom:5px;"
                        target="_blank">PAGAR SALDO
                        COM BOLETO</a>--}}
                        <a class="btn btn-info btn-block p-3"
                            href="{{route('portal.extrato.produto.paycredit', ['prod' => $prod['id']])}}">PAGAR
                            SALDO
                            COM CARTÃO DE CRÉDITO</a>
                    </div>
                    @endif

                    @endif
                </div>
            </div>
            @endif
            <div class="panel-body">

                <div class="row">

                    @if($saldo_pagar <= 0) <div class="col-md-12" style="font-size: 16px;">
                        <table class="table table-bordered">
                            <tr class="text-center">
                                <td colspan="2">
                                    <img src="{{ asset("img/icon_pago.png") }}" class="img-responsive"
                                        style="max-height: 100px;">
                                    <hr>
                                    <h2 style="color: #00ad21">Parabéns Tudo Pago!</h2>
                                </td>
                            </tr>
                        </table>
                </div>

                @else


                <div class="col-md-12" style="font-size: 16px;">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center">Total</th>
                                <th class="text-center">Valor Pago</th>
                                <th class="text-center">Saldo</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>R$ {{number_format($prod->valorFinal(), 2, ",", ".")}}</td>
                                <td>R$ {{number_format($valor_pago_p, 2, ",", ".")}}</td>
                                <td>R$ {{number_format($saldo_pagar, 2, ",", ".")}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                @endif
                <a href="{{route('portal.extrato.produto.payment', ['prod' => $prod['id']])}}" class="btn btn-info float-right"
                    target="_blank">Efetuar Pagamento</a>
            </div>            
        </section>
        
    </div>

</section>
<script type="text/javascript"
    src="https://stc.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js"></script>
<script type="text/javascript">
    $(function(){
            $(".a-vencer-click").click(function (e) {
                alert("Seu boleto estará disponível 30 dias antes do vencimento");
            });
            
            $(".boleto-imprimir").click(function (e) {                
                let url = "";
                url = $(this).attr('href_javascript');
                if(url.length < 50){
                    url += '/'+hash;
                    //this.href = url;
                    location.replace(url);
                }
                
            });
        });

    PagSeguroDirectPayment.setSessionId('{{$id_sessao}}');
    PagSeguroDirectPayment.onSenderHashReady(function(response){
    if(response.status == 'error') {
        alert('Ocorreu um erro, por favor atualize a página');
        console.log(response.message);
        return false;
    }
    hash = response.senderHash; //Hash estará disponível nesta variável.
    });   
</script>


@endsection