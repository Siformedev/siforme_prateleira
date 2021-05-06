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

                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <h1>Compras Extras</h1>
                        </div>
                    </div>


                    @if($product != null)



                        @foreach($product as $p)


                            <section class="panel panel-with-borders">
                                <div class="panel-heading">
                                    <h5>{{ $p['name'] }}</h5>
                                </div>
                                <div class="panel-body" onclick="window.location = '{{route('portal.comprasextras.comprar', ['produto' => $p['id'], 'quantidade' => 1, 'dia_pagamento' => 10, 'tppg' => 'boleto'])}}'" data-clicked="0" data-category="{{ $p['category_id'] }}" data-price="{{ $p['values']['value'] }}" style="cursor: pointer;" onclick="addProd('{{ $p['id'] }}')">
                                    <div class="row">
                                        <div class="col-md-2"><img id="img-prod_{{ $p['id'] }}" class="img-responsive img-thumbnail img-circle img-prod" style="width: 150px; height: 150px;" src="{{ $p['img'] }}" data-imagesource="{{ $p['img'] }}"></div>
                                        <div class="col-md-6">
                                            <p>{!! nl2br($p['description'])  !!}</p>
                                        </div>
                                        <?php

                                        if(isset($p['discounts'][1]['maximum_parcels'])){
                                            $descontoAVista = $p['discounts'][1]['value'] / 100;
                                            $valorDescontoAVista = $p['values']['value'] - ($descontoAVista * $p['values']['value']);
                                        }
                                        $ii = 0;
                                        foreach($p['max_parcels'] as $parc){
                                            $ii++;
                                            if($ii == 3){
                                                $maxParcelasCartao = ($parc['parcelas'] > 12 ? 12 : $parc['parcelas']);
                                            }

                                        }
                                        ?>

                                        <!--
                                        <div class="col-sm-12 col-md-3 text-center">
                                            <section class="panel panel-with-borders" style="min-height: 320px;">
                                                <div class="panel-body">
                                                    <h5><img src="http://download.seaicons.com/download/i95821/iconsmind/outline/iconsmind-outline-credit-card-2.ico" height="30"> CARTÃO DE CRÉDITO</h5>
                                                    <hr>
                                                    Parcelado em até {{ $maxParcelasCartao }}X sem juros <br><span class="label label-success margin-inline margin-3" style="font-size: 24px">R$ {{ number_format( ($p['values']['value']) , 2, ",", ".") }}</span>
                                                    <hr>

                                                    <!--
                                                    <div class="col-xs-12">
                                                        <div class="input-group number-spinner">
                        <span class="input-group-btn">
                            <button class="btn btn-default" data-dir="dwn"><span class="glyphicon glyphicon-minus"></span></button>
                        </span>
                                                            <input type="number" class="form-control text-center" value="1">
                                                            <span class="input-group-btn">
                            <button class="btn btn-default" data-dir="up"><span class="glyphicon glyphicon-plus"></span></button>
                        </span>
                                                        </div>
                                                    </div>



                                                    <div class="col-xs-3 col-xs-offset-3">
                                                        <div class="input-group number-spinner">
                        <span class="input-group-btn data-dwn">
                            <button class="btn btn-default btn-info" data-dir="dwn"><span class="glyphicon glyphicon-minus"></span></button>
                        </span>
                                                            <input type="text" class="form-control text-center" value="1" min="-10" max="40">
                                                            <span class="input-group-btn data-up">
                            <button class="btn btn-default btn-info" data-dir="up"><span class="glyphicon glyphicon-plus"></span></button>
                        </span>
                                                        </div>
                                                    </div>



                                                    <span>


                                                        </span>
                                                </div>
                                            </section>
                                        </div>
                                        -->


                                        <div class="col-sm-12 col-md-4 text-center">
                                            <section class="panel panel-with-borders" style="min-height: 320px;">
                                                <div class="panel-body">
                                                    @if($p['id'] == 31)
                                                        <h5><img src="https://cdn0.iconfinder.com/data/icons/50-payment-system-icons-2/480/Boleto.png" height="30"> BOLETO BANCÁRIO</h5>
                                                            <span class="label label-success margin-inline margin-3" style="font-size: 24px">R$ 390,00 <span style="font-size: 12px;">*(Somente à vista)</span></span>
                                                            <br> OU <br>
                                                        <h5> <img src="https://png.pngtree.com/svg/20161211/6bd3eab19c.png" style="height: 20px;"> CARTÃO DE CRÉDITO</h5>
                                                        <span class="label label-success margin-inline margin-3" style="font-size: 24px">R$ 420,00</span>

                                                    @else
                                                    <h5><img src="https://cdn0.iconfinder.com/data/icons/50-payment-system-icons-2/480/Boleto.png" height="30"> BOLETO BANCÁRIO <br> OU <br><img src="https://png.pngtree.com/svg/20161211/6bd3eab19c.png" style="height: 20px;"> CARTÃO DE CRÉDITO</h5>
                                                    <hr>
                                                    <span style="font-size: 13px;"> @if(isset($valorDescontoAVista)) C/ {{ $descontoAVista*100 }}% de desconto (*Somente no boleto) @endif
                                                        <br>
                                                        <span class="label label-success margin-inline margin-3" style="font-size: 24px">R$ {{ number_format( (isset($valorDescontoAVista)?$valorDescontoAVista:$p['values']['value']) , 2, ",", ".") }}</span>
                                                    <hr>
                                                    @endif

                                                    <!--
                                                    <div class="col-xs-12">
                                                        <div class="input-group number-spinner">
                        <span class="input-group-btn">
                            <button class="btn btn-default" data-dir="dwn"><span class="glyphicon glyphicon-minus"></span></button>
                        </span>
                                                            <input type="number" class="form-control text-center" value="1">
                                                            <span class="input-group-btn">
                            <button class="btn btn-default" data-dir="up"><span class="glyphicon glyphicon-plus"></span></button>
                        </span>
                                                        </div>
                                                    </div>


                                                    <div class="col-xs-3 col-xs-offset-3">
                                                        <div class="input-group number-spinner">
                        <span class="input-group-btn data-dwn">
                            <button class="btn btn-default btn-info" data-dir="dwn"><span class="glyphicon glyphicon-minus"></span></button>
                        </span>
                                                            <input type="text" class="form-control text-center" value="1" min="-10" max="40">
                                                            <span class="input-group-btn data-up">
                            <button class="btn btn-default btn-info" data-dir="up"><span class="glyphicon glyphicon-plus"></span></button>
                        </span>
                                                        </div>
                                                    </div>
                                                    -->

{{--                                                    <span>--}}
{{--                                                            @if(isset($p['discounts']))--}}
{{--                                                            @foreach($p['discounts'] as $desc)--}}
{{--                                                                @if($desc['maximum_parcels'] > 1)--}}
{{--                                                                    <span style="font-size: 9px"> ou R$ <b>{{ number_format($p['values']['value'] - (($desc['value'] / 100) * $p['values']['value']), 2, ",", ".") }}</b> em até {{ $desc['maximum_parcels'] }}X com <b>{{ $desc['value'] }}%</b> de desconto </span> <br>--}}
{{--                                                                @endif--}}
{{--                                                            @endforeach--}}
{{--                                                        @endif--}}

{{--                                                        @foreach($p['max_parcels'] as $parc)--}}
{{--                                                            <span style="font-size: 8px"> ou R$ {{ number_format($p['values']['value'], 2, ",", ".") }} em até {{ $parc['parcelas']}}X com o primeira para {{ date('d/m', strtotime($parc['priPagamento'])) }} </span><br>--}}
{{--                                                        @endforeach--}}
{{--                                                        </span>--}}
                                                </div>
                                            </section>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-footer">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <button type="button" class="btn btn-info btn-block" data-toggle="modal" data-target="#myModal_{{ $p['id'] }}">Termo</button>
                                        </div>
                                        <div class="col-md-6">
                                            <a href="{{route('portal.comprasextras.comprar', ['produto' => $p['id'], 'quantidade' => 1, 'dia_pagamento' => 10, 'tppg' => 'boleto'])}}" type="button" class="btn btn-success btn-block">Comprar</a>
                                        </div>
                                    </div>
                                    <!-- Modal -->
                                    <div id="myModal_{{ $p['id'] }}" class="modal fade modal-size-large" role="dialog">
                                        <div class="modal-dialog">
                                            <!-- Modal content-->
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    <h4 class="modal-title">{{$p['termo']['titulo']}}</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <p>{!!  $p['termo']['conteudo']!!}</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">OK</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                            @php
                                    unset($descontoAVista);
                                    unset($valorDescontoAVista);
                            @endphp
                        @endforeach()
                    @else
                        <section class="panel panel-with-borders">
                            <div class="panel-heading">
                                <h5>Nenhum produto extra foi cadastrado até o momento...</h5>
                            </div>
                        </section>
                    @endif
                </div>
                <div class="panel-footer">

                </div>
            </section>

                </div>
                <div class="panel-footer">
                </div>
            </section>


        </div>
    </section>

@endsection
