@extends('adesao.inc.layout')

@section('content')


    <section class="page-content">

        <div class="page-content-inner margin-top-10">

            <!-- Basic Form Elements -->
            <section class="panel">
                <div class="panel-body">
                    {!! Form::open(['route' => 'adesao.vpagamento']) !!}
                    <section class="panel panel-with-borders">
                        <div class="panel-heading">
                            <h3><img src="{{asset('img/credit-card.png')}}" style="height: 30px;">
                                Pagamento com Cartão de Crédito
                                <a href="{{route('adesao.pagamento')}}" class="btn btn-bottom float-right">TROCAR</a>
                            </h3>
                        </div>
                        <div class="panel-body">




                            @foreach($product as $p)

                                <section class="panel panel-with-borders">
                                    <div class="panel-body selectProduct_{{ $p['id'] }}" data-id="{{ $p['id'] }}">
                                        <div class="row">
                                            <div class="col-md-3"><img id="img-prod_{{ $p['id'] }}" class="img-responsive img-thumbnail img-circle img-prod" style="width: 150px; height: 150px;" src="{{ $p['img'] }}" data-imagesource="{{ $p['img'] }}"></div>
                                            <div class="col-md-5">
                                                <h5>{{ $p['name'] }}</h5>
                                                <p>{{ $p['description'] }}</p>
                                            </div>
                                            <?php
                                            if(isset($p['discounts'][1]['maximum_parcels'])){
                                                $descontoAVista = $p['discounts'][1]['value'] / 100;
                                                $valorDescontoAVista = $p['values']['value'] - ($descontoAVista * $p['values']['value']);
                                            }
                                            ?>
                                            <div class="col-sm-12 col-md-4 text-center">
                                                À Vista @if(isset($valorDescontoAVista)) C/ {{ $descontoAVista*100 }}% de desconto @endif <br><span class="label label-success margin-inline margin-3" style="font-size: 24px">R$ {{ number_format( (isset($valorDescontoAVista)?$valorDescontoAVista:$p['values']['value']) , 2, ",", ".") }}</span>
                                                <hr>

                                                <span>
                                                @if(isset($p['discounts']))
                                                    @foreach($p['discounts'] as $desc)
                                                        @if($desc['maximum_parcels'] > 1)
                                                            @if($desc['maximum_parcels'] > 12)
                                                                Em até 12X com {{ $desc['value'] }}% de desconto <br>
                                                            @else
                                                                Em até {{ $desc['maximum_parcels'] }}X com {{ $desc['value'] }}% de desconto <br>
                                                            @endif
                                                        @endif
                                                    @endforeach
                                                @endif

                                                @php

                                                        foreach ($p['max_parcels'] as $parc_max){
                                                            if($parc_max['parcelas'] > 12){
                                                                $max_credit = 12;
                                                            }else{
                                                                $max_credit = $parc_max['parcelas'];
                                                            }
                                                            break;
                                                        }

                                                @endphp
                                                {{--<span style="font-size: 10px"> Em até {{ $parc['parcelas'] }}X com o primeiro pagamento para {{ date('d/m/Y', strtotime($parc['priPagamento'])) }} </span><br>--}}

                                            </span>

                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    {{ Form::label('parcelas_prod_'.$p['id'], 'Escolha o parcelamento:') }}
                                                    {{ Form::select('parcelas_prod_['.$p['id'].']', array_merge([0 => 'Selecione o parcelamento desejado...'], $product[$p['id']]['parcels']), 0 , array_merge(['class' => 'form-control', 'id' => 'parcelas_prod_'.$p['id']])) }}
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </section>
                                @php
                                    unset($descontoAVista, $valorDescontoAVista);
                                @endphp
                            @endforeach()

                        </div>
                    </section>

                    <div class="row">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-success btn-block" id="btn-concluir">Confirmar e concluir adesão</button>
                        </div>
                    </div>
                    <input type="hidden" name="paytype" value="2">
                    {!! Form::close() !!}
                </div>
            </section>
        </div>

    </section>

    <script>
        var submit = 0;
        $(function () {
            $('#dia_pagamento').change(function () {
                var dia = $(this).val();
                window.location = '/adesao/pagamento/'+dia+'?paytype=1';
            });


            $('#btn-concluir').click(function () {
                if(submit == 0){
                    submit = 1;
                    $('#btn-concluir').attr('disabled', true).html('Estamos cadastrando sua adesão, favor aguarde,...');
                    $('form').submit();
                }

            });

        });
    </script>

@endsection