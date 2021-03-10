@extends('gerencial.inc.layout')

@section('content')


    <section class="page-content">
        <div class="page-content-inner">

            <section class="panel">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-11">
                            <h3>{{$prod['name']}}</h3>
                        </div>
                        <div class="col-md-1"><a class="btn btn-default" href="{{route('gerencial.formando.show', ['forming' => $forming->id])}}">Voltar</a> </div>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-1">
                            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS9hAAvkAoU2EEDF8terQ3Bvk--mIQAnihJpcDmL0Wmfy5Czw23" style="width: 100px;">
                        </div>
                        <div class="col-md-11">
                            <b>Descrição:</b> <br>
                            {{$prod['description']}}
                            @if($prod['withdrawn'] > 0)
                                <br><span class="label label-warning font-size-18" style="padding: 10px; margin-top: 10px;">Retirado {{ $prod['withdrawn'] }} convite (s)</span>
                            @endif
                            <!--
                            <div class="row">
                                <div class="col-md-12">
                                    <hr>
                                    <span>Percentual já Pago (75%)</span>
                                    <progress class="progress progress-warning progress-striped" value="25" max="100">75%</progress>
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
                                        <button type="button" class="btn btn-default-outlined margin-inline" data-toggle="tooltip" data-placement="top" title="" data-original-title="Correção monetária que acontece de 12 em 12 meses">
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
                                        :</th>
                                    <td>{{Carbon\Carbon::parse($prod['reset_igpm'])->format('d/m/Y')}}</td>
                                </tr>
                                <!--
                                <tr>
                                    <th scope="row">Status</th>
                                    <td>Adimplente</td>
                                </tr>
                                -->
                                <tr class="">
                                    <th scope="row">TERMO DE ADESÃO</th>
                                    <td><button type="button" class="btn btn-success margin-inline"  data-toggle="modal" data-target="#myModal_{{ $termo['id'] }}">Visualizar</button></td>
                                </tr>
                            </table>
                            <!-- Modal -->
                            <div id="myModal_{{ $termo['id'] }}" class="modal fade modal-size-large" role="dialog">
                                <div class="modal-dialog">
                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title">{{$termo['titulo']}}</h4>
                                        </div>
                                        <div class="modal-body">
                                            <p>{!!  $termo['conteudo']!!}</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">OK</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>
                    <h3>Parcelas</h3>

                    <div class="row">
                        <div class="col-md-12" style="font-size: 16px;">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th class="text-center">Id Formando</th>
                                        <th class="text-center">Parcela Pgto ID</th>
                                        <th class="text-center">Referencia PagSeguro</small></th>
                                        <th class="text-center">Ordem de pagamento</th>
                                        <th class="text-center">Status da transação</th>
                                        <th class="text-center">Data do pagamento</th>
                                        <th class="text-center">Vencimento</th>
                                        <th class="text-center">Valor</th>
                                        <th class="text-center">Valor Pago</th>
                                        <th class="text-center">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($parcelas as $parcela)
                                    @php

                                        $sumpg = 0;
                                        if(isset($pagamentos[$parcela['id']])){
                                            $parc = $pagamentos[$parcela['id']];
                                            $sumpg = $parc->valor_pago;
                                        }


                                        // if($sumpg >= $parcela['valor']){




                                        if($parcela['status'] == 'Pago'){
                                           $actionParc = '<span class="label label-success">PAGO</span>';
                                        }elseif($sumpg <= 0){

                                            if(date('Y-m-d', strtotime($parcela['dt_vencimento'])) <= $dateLimit->format('Y-m-d')){
                                                if(date('Y-m-d', strtotime($parcela['dt_vencimento'])) < date('Y-m-d')){
                                                    //$actionParc = '<span class="label label-warning" title="Seu boleto estará disponível 5 dias antes do vencimento" target="_blank">Emitindo seu boleto...</span>';
                                                    $actionParc = '<span class="label label-danger" target="_blank">Vencida</span>';
                                                }else{
                                                    $actionParc = '<span class="label label-warning" title="Seu boleto estará disponível 15 dias antes do vencimento">Disponível</span>';
                                                    //$actionParc = '<span class="label label-warning" title="Seu boleto estará disponível 5 dias antes do vencimento" target="_blank">Emitindo seu boleto...</span>';
                                                }
                                            }else{
                                                if(date('Y-m-d', strtotime($parcela['dt_vencimento'])) < date('Y-m-d')){
                                                    //$actionParc = '<span class="label label-warning" title="Seu boleto estará disponível 5 dias antes do vencimento" target="_blank">Emitindo seu boleto...</span>';
                                                    $actionParc = '<span class="label label-danger">Vencida</span>';
                                                }else{
                                                    $actionParc = '<span class="label label-primary" title="Seu boleto estará disponível 15 dias antes do vencimento">A Vencer</span>';
                                                }

                                            }
                                        }
 
                                        
                                        
                                                            
                                    @endphp 
                                    <tr>
                                      @if ($parcela['invoice_id']=='01082B57-91C6-4069-94A6-FDDF8A922226')

                                        <td class="text-center">{{$parc}}</td>
                                        @endif
                                            
                                    
                                        
                                        <td class="text-center">{{$parcela['formandos_id']}}</td>
                                        <td class="text-center">{{$parcela['parcela_pagamento_id']}}</td>
                                        <td class="text-center">{{$parcela['parcela_id']}}</td>
                                        <td class="text-center">{{$parcela['invoice_id']}}</td>
                                        <td class="text-center">{{$parcela['status']}}</td>
                                        
                                        @if ($parcela['status']!='Pago' )
                                        <td class="text-center">-</td>  
                                        @else
                                        <td class="text-center">{{date('d/m/Y', strtotime($parcela['paid_at']))}}</td>   
                                        @endif
                                        
                                      
                                        <td class="text-center">{{date('d/m/Y', strtotime($parcela['dt_vencimento']))}}</td>
                                        <td class="text-center">{{number_format($parcela['valor'],2, ",", ".")}}</td>
                                        
                                        @if ($parcela['status']=='Pendente' || is_null($parcela['status']))
                                        <td class="text-center">{{number_format(0,2, ",", ".")}}</td>
                                        @else                                    
                                    
                                        <td class="text-center">{{number_format($parcela['valor_pago'],2, ",", ".")}}</td>
                                        @endif

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
        </div>

    </section>

    <script type="text/javascript">
        $(function(){

        });
    </script>

@endsection
