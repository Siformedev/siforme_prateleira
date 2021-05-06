@extends('comissao.inc.layout')

@section('content')


    <section class="page-content">
        <div class="page-content-inner">

            <section class="panel">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-11">
                            <h3>{{$prod['name']}}</h3>
                        </div>
                        <div class="col-md-1"><a class="btn btn-default" href="{{route('portal.extrato')}}">Voltar</a> </div>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-1">
                            <img src="{{$prod['img']}}" style="width: 100px;">
                        </div>
                        <div class="col-md-11">
                            <b>Descrição:</b> <br>
                            {{$prod['description']}}
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
                                    <td><a href="{{route('portal.termo.pdf', ['product' => $prod['id']])}}" class="btn btn-success" target="_blank">Imprimir</a></td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <hr>
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
                                    $sumpg = 0;
                                    if(isset($pagamentos[$parcela['id']])){
                                        $parc = $pagamentos[$parcela['id']];
                                        $sumpg = $parc->valor_pago;
                                    }

                                    if($sumpg >= $parcela['valor']){
                                        $actionParc = '<span class="label label-success">PAGO</span>';
                                    }elseif($sumpg <= 0){

                                        if(date('Y-m-d', strtotime($parcela['dt_vencimento'])) <= $dateLimit->format('Y-m-d')){
                                            if(date('Y-m-d', strtotime($parcela['dt_vencimento'])) < date('Y-m-d')){
                                                //$actionParc = '<span class="label label-warning" title="Seu boleto estará disponível 5 dias antes do vencimento" target="_blank">Emitindo seu boleto...</span>';
                                                $actionParc = '<a href="'.route('portal.formando.boleto',['parcela' => $parcela['id']]).'" class="label label-danger" target="_blank">Vencida</a>';
                                            }else{
                                                $actionParc = '<a href="'.route('portal.formando.boleto',['parcela' => $parcela['id']]).'" class="label label-warning" title="Seu boleto estará disponível 15 dias antes do vencimento" target="_blank">Imprimir</a>';
                                                //$actionParc = '<span class="label label-warning" title="Seu boleto estará disponível 5 dias antes do vencimento" target="_blank">Emitindo seu boleto...</span>';
                                            }
                                        }else{
                                            if(date('Y-m-d', strtotime($parcela['dt_vencimento'])) < date('Y-m-d')){
                                                //$actionParc = '<span class="label label-warning" title="Seu boleto estará disponível 5 dias antes do vencimento" target="_blank">Emitindo seu boleto...</span>';
                                                $actionParc = '<a href="'.route('portal.formando.boleto',['parcela' => $parcela['id']]).'" class="label label-danger" target="_blank">Vencida</a>';
                                            }else{
                                                $actionParc = '<span class="label label-primary" title="Seu boleto estará disponível 15 dias antes do vencimento">A Vencer</span>';
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
        </div>

    </section>

    <script type="text/javascript">
        $(function(){

        });
    </script>

@endsection