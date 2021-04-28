@extends('portal.inc.layout')

@section('content')
    <section class="page-content">
        <div class="page-content-inner">
            <section class="panel">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-2"><img class="img-responsive img-thumbnail img-circle img-prod" style="width: 150px; height: 150px;" src="{{ $product['product']->img }}"></div>
                        <div class="col-md-5">
                            <h3>{{$product['product']->name}}</h3>
                            <h1><span class="label label-success">R$ {{ number_format($product['values']['value'],2, ",", ".") }}</span> x <span class="label label-warning">{{ number_format($quantidade,0) }}</span> = <span class="label label-info">R$ {{ number_format(($product['values']['value'] * $quantidade),2, ",", ".") }}</span></h1>
                        </div>
                        <div class="col-md-4">
                            <span>
                               @if(isset($product['discounts']))
                                    <span class="label">Descontos</span><hr>
                                    @foreach($product['discounts'] as $desc)
                                        @if($desc['maximum_parcels'] > 1)
                                            <span style="font-size: 9px"> ou R$ <b>{{ number_format($product['values']['value'] - (($desc['value'] / 100) * $product['values']['value']), 2, ",", ".") }}</b> em até {{ $desc['maximum_parcels'] }}X com <b>{{ $desc['value'] }}%</b> de desconto </span> <br>
                                        @endif
                                    @endforeach
                                @endif
                                <br><br>
                                <span class="label">Parcelamento</span><hr>
                                @foreach($product['max_parcels'] as $parc)
                                    <span style="font-size: 8px"> ou R$ {{ number_format($product['values']['value'], 2, ",", ".") }} em até {{ $parc['parcelas']}}X com o primeira para {{ date('d/m', strtotime($parc['priPagamento'])) }} </span><br>
                                @endforeach
                            </span>
                        </div>
                        <div class="col-md-1"><a class="btn btn-default" href="{{route('portal.albuns')}}">Voltar</a> </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <hr>
                        <div class="col-md-12">
                            <b>Descrição:</b> <br>
                            {!! nl2br($product['product']['description']) !!}
                        </div>
                    </div>

                    <hr>


                    <h3>Dados para Compra e Pagamento</h3>
                    {!! Form::open(['route' => 'portal.albuns.store']) !!}
                    <div class="row">
                        <hr>
                        <div class="col-md-4">
                            <div class="form-group">
                                @php
                                $selectArrays = (isset($product['limiteQt']) or $product['limiteQt'] > 0) ? [$product['limiteQt'] => $product['limiteQt']] : $product['selectQuantidade'];
                                @endphp
                                {{ Form::label('quantidade', 'Quantidade') }}
                                {{ Form::select('quantidade', $selectArrays, $quantidade, array_merge(['class' => 'form-control selectsActives', 'id' => 'selectQuantidade'])) }}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                {{ Form::label('dia_pagamento', 'Dia do Pagamento') }}
                                {{ Form::select('dia_pagamento', $product['selectDiaPagamento'], $dia_pagamento, array_merge(['class' => 'form-control selectsActives', 'id' => 'diaPagamento'])) }}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                {{ Form::label('parcelas', 'Parcelas') }}
                                {{ Form::select('parcelas', $product['parcels'], null, array_merge(['class' => 'form-control', 'id' => 'selectQuantidade'])) }}
                            </div>
                        </div>

                        {{ Form::hidden('prodId', $product['product']['id'], ['id' => 'prodId']) }}
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-success btn-block">Confirmar e Comprar</button>
                        </div>
                    </div>
                    {!! Form::close() !!}


                </div>
                <div class="panel-footer">

                </div>
            </section>
        </div>

    </section>

    <script>
        $(function () {
            $('.selectsActives').change(function () {
                var prodId = $('#prodId').val();
                var qt = $('#selectQuantidade').val();
                var dia = $('#diaPagamento').val();
                window.location = '/portal/comprasextras/'+prodId+'/'+qt+'/'+dia;
            });
        });
    </script>

@endsection