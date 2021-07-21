@extends('adesao.inc.layout')

@section('content')


    <section class="page-content">
        <div class="page-content-inner">

            <!-- Basic Form Elements -->
            <section class="panel">
                <div class="panel-heading">
                    <h3>Confirmação dos dados</h3>
                </div>
                <div class="panel-body">
                    <style>
                        .spnLabel {
                            display: block;
                            font-size: 14px;
                            background: #f1f1f1;
                            padding:4px;
                        }
                        .labelText {
                            font-size: 18px;
                            padding: 5px;
                            border: 1px solid #f1f1f1;
                            border-radius: 5px;
                        }
                    </style>
                    <div class="row">

                        <!-- Dados Pessoais -->

                        <div class="col-md-12 col-lg-4 labelText"><span class="spnLabel">Nome</span>{{ $dataConfirma['nome'] . ' ' . $dataConfirma['sobrenome'] }}&nbsp;</div>
                        <div class="col-md-12 col-lg-4 labelText"><span class="spnLabel">CPF</span>{{ $dataConfirma['cpf'] }}&nbsp;</div>
                        <div class="col-md-12 col-lg-4 labelText"><span class="spnLabel">RG</span>{{ $dataConfirma['rg'] }}&nbsp;</div>
                        <div class="col-md-12 col-lg-4 labelText"><span class="spnLabel">Data de Nascimento</span>{{ $dataConfirma['datanascimento'] }}&nbsp;</div>
                        <div class="col-md-12 col-lg-4 labelText"><span class="spnLabel">Sexo</span>{{ $dataConfirma['sexo'] }}</div>

                        <!-- Endereço -->

                        <div class="col-md-12 col-lg-4 labelText"><span class="spnLabel">CEP</span>{{ $dataConfirma['cep'] }}&nbsp;</div>
                        <div class="col-md-12 col-lg-4 labelText"><span class="spnLabel">Endereço</span>{{ $dataConfirma['logradouro'] . ', ' . $dataConfirma['numero'] . ', ' . $dataConfirma['complemento']}}&nbsp;</div>
                        <div class="col-md-12 col-lg-3 labelText"><span class="spnLabel">Bairro</span>{{ $dataConfirma['bairro'] }}&nbsp;</div>
                        <div class="col-md-12 col-lg-3 labelText"><span class="spnLabel">Cidade</span>{{ $dataConfirma['cidade'] }}&nbsp;</div>
                        <div class="col-md-12 col-lg-2 labelText"><span class="spnLabel">Estado</span>{{ $dataConfirma['estado'] }}&nbsp;</div>

                        <!-- Contato -->

                        <div class="col-md-12 col-lg-4 labelText"><span class="spnLabel">E-mail</span>{{ $dataConfirma['email'] }}&nbsp;</div>
                        <div class="col-md-12 col-lg-4 labelText"><span class="spnLabel">Telefone Residencial</span>{{ $dataConfirma['telefone-residencial'] }}&nbsp;</div>
                        <div class="col-md-12 col-lg-4 labelText"><span class="spnLabel">Telefone Celular</span>{{ $dataConfirma['telefone-celular'] }}&nbsp;</div>

                        <div class="col-md-12 col-lg-4 labelText"><span class="spnLabel">Nome do Pai</span>{{ $dataConfirma['nome_do_pai'] }}&nbsp;</div>
                        <div class="col-md-12 col-lg-4 labelText"><span class="spnLabel">E-mail do Pai</span>{{ $dataConfirma['email_do_pai'] }}</div>
                        <div class="col-md-12 col-lg-4 labelText"><span class="spnLabel">Telefone do Pai</span>{{ $dataConfirma['telefone_celular_pai'] }}&nbsp;</div>

                        <div class="col-md-12 col-lg-4 labelText"><span class="spnLabel">Nome da Mãe</span>{{ $dataConfirma['nome_da_mae'] }} &nbsp;</div>
                        <div class="col-md-12 col-lg-4 labelText"><span class="spnLabel">E-mail da Mãe</span>{{ $dataConfirma['email_da_mae'] }}&nbsp;</div>
                        <div class="col-md-12 col-lg-4 labelText"><span class="spnLabel">Telefone da Mãe</span>{{ $dataConfirma['telefone_celular_mae'] }}&nbsp;</div>

                        <div class="col-md-12 col-lg-4 labelText"><span class="spnLabel">Altura</span>{{ str_replace("'","",str_replace(".",",",$dataConfirma['altura'])) }} &nbsp;</div>
                        <div class="col-md-12 col-lg-4 labelText"><span class="spnLabel">Camiseta</span>{{ $dataConfirma['camiseta'] }}&nbsp;</div>
                        <div class="col-md-12 col-lg-4 labelText"><span class="spnLabel">Calçado</span>{{ $dataConfirma['calcado'] }}&nbsp;</div>



                    </div>
                </div>
            </section>
        </div>

        <div class="page-content-inner margin-top-10">

            <!-- Basic Form Elements -->
            <section class="panel">
                <div class="panel-body">

                    <section class="panel panel-with-borders">
                        <div class="panel-heading">
                            <h3>Produtos e Serviços</h3>
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
                                    </div>
                                </section>
                                @php
                                    unset($descontoAVista, $valorDescontoAVista);
                                @endphp
                            @endforeach()
                        </div>
                    </section>

                    {!! Form::open(['route' => 'adesao.vconfirma']) !!}
                    <div class="row">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-success btn-block">Confirmar e seguir para pagamentos</button>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </section>
        </div>

    </section>

@endsection