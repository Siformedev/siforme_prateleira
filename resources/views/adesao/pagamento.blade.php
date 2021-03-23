@extends('adesao.inc.layout')

@section('content')


    <section class="page-content">

        <div class="page-content-inner margin-top-10">

            @if (session('erro_parcelamento'))
                <div class="alert alert-danger">
                    <ul>
                        <li>{{ session('erro_parcelamento') }}</li>
                    </ul>
                </div>
            @endif


            <!-- Basic Form Elements -->
            <section class="panel">
                <div class="panel-body">
                    {!! Form::open(['route' => 'adesao.vpagamento']) !!}
                    <section class="panel panel-with-borders">
                        <div class="panel-heading">
                                <h3>PAGAMENTO</h3>
{{--                            <h3>--}}
{{--                                <img src="{{asset('img/boleto.png')}}" style="height: 30px;">--}}
{{--                                Pagamento com Boleto--}}
{{--                                <a href="{{route('adesao.pagamento')}}" class="btn btn-bottom float-right">TROCAR</a>--}}
{{--                            </h3>--}}

                        </div>
                        <div class="panel-body">

                            @if( session()->get('contrato')['code'] == 'magister2019' )
                            <div class="panel-group accordion" id="accordion" role="tablist" aria-multiselectable="true">
                                <div class="panel panel-default">
                                    <div class="panel-heading collapsed" role="tab" id="headingOne" data-toggle="collapse" data-parent="#accordion" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        <div class="panel-title">
                                        <span class="accordion-indicator pull-right">
                                            <i class="plus fa fa-plus"></i>
                                            <i class="minus fa fa-minus"></i>
                                        </span>
                                            <a>
                                                PAGAMENTO COM CARTÃO DE CRÉDITO
                                            </a>
                                        </div>
                                    </div>
                                    <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                                        <div class="panel-body">
                                            <p style="color: #55595c">
                                                O pagamento através do cartão de crédito só é realizado dentro da plataforma após o cadastro realizado.<br><br>
                                                Caso queira essa opção, selecione abaixo qualquer quantidade de parcela e conclua. Após cadastrado efetua, faça login no portal do formando (conforme instruções que será enviada por e-mail), acesse: Extrato > Formatura Pacote Completo > PAGAR SALDO COM CARTÃO DE CRÉDITO. Escolha a quantidade de parcelas, insira os dados do cartão e pronto!<br><br>
                                                <br>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            @endif

                            <section class="panel panel-with-borders">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                {{ Form::label('dia_pagamento', 'Escolha data para pagamento') }}
                                                {{ Form::select('dia_pagamento', $dias_pagamento, $dia_get , array_merge(['class' => 'form-control', 'id' => 'dia_pagamento'])) }}

                                              </div>
                                        </div>
                                    </div>
                                </div>
                            </section>


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
                                                            Em até {{ $desc['maximum_parcels'] }}X com {{ $desc['value'] }}% de desconto <br>
                                                        @endif
                                                    @endforeach
                                                @endif

                                                @foreach($p['max_parcels'] as $parc)
                                                    <span style="font-size: 10px"> Em até {{ $parc['parcelas'] }}X com o primeiro pagamento para {{ date('d/m/Y', strtotime($parc['priPagamento'])) }} </span><br>
                                                @endforeach

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
                    <input type="hidden" name="paytype" value="1">
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
