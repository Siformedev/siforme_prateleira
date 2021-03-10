@extends('adesao.inc.layout')

@section('content')



    <section class="page-content">
        <div class="page-content-inner">

            <!-- Basic Form Elements -->
            <section class="panel">
                <div class="panel-heading">
                    <h3>Dados da Adesão</h3>
                </div>
                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('msgerro'))
                    <div class="alert alert-danger">
                        <ul>
                                <li>{{ session('msgerro') }}</li>
                        </ul>
                    </div>
                @endif
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">

                            <h4></h4>
                            <br />
                            <!-- Horizontal Form -->

                            {!! Form::open(['route' => 'adesao.validcontrato']) !!}
                            <div class="form-group row">
                                <div class="col-md-2">
                                    {!! Form::label('nome-da-turma', 'Nome da Turma', ['class' => 'form-control-label']) !!}
                                </div>
                                <div class="col-md-10">
                                    {!! Form::text('contract-name', $contrato->name, ['class' => 'form-control', 'disabled' => true]) !!}
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-2">
                                    {!! Form::label('institution', 'Instituição', ['class' => 'form-control-label']) !!}
                                </div>
                                <div class="col-md-10">
                                    {!! Form::text('institution', $contrato->institution, ['class' => 'form-control', 'disabled' => true]) !!}
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-2">
                                    {!! Form::label('conclusion', 'Conclusão', ['class' => 'form-control-label']) !!}
                                </div>
                                <div class="col-md-10">
                                    {!! Form::text('conclusion', $mes.'/'.$contrato->conclusion_year, ['class' => 'form-control', 'disabled' => true]) !!}
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-2">
                                    {!! Form::label('curso', 'Curso', ['class' => 'form-control-label']) !!}
                                </div>
                                <div class="col-md-10">
                                    @php

                                    if(isset($register)){$curso_id = $register['course'];}elseif(isset($data['curso'])){$curso_id = $data['curso'];}else{$curso_id = null;}
                                    @endphp
                                    {!! Form::select('course', $courses, $curso_id, ['class' => 'form-control validCourse', 'required' => 'required']) !!}
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-2">
                                    {!! Form::label('periodo', 'Período', ['class' => 'form-control-label']) !!}
                                </div>
                                <div class="col-md-10">
                                    
                                    {!! Form::select('periodo', $periodos, @$data["periodo"], ['class' => 'form-control validCourse', 'required' => 'required']) !!}
                                </div>
                            </div>
                            
                            {!! Form::hidden('code', $contrato->code) !!}
                            {!! Form::hidden('valid', $contrato->valid) !!}
                            <div id="inputsHiden">

                            </div>

                        </div>
                    </div>
                </div>

                <div class="panel-body">

                    <style>
                        hr{                            
                            border-top: 0;
                        }
                        .panel-heading
                        {                            
                            border-top: 0;
                        }
                        .prodForm_1 {
                             border: 1px solid #2c98f0;
                             background-color: rgba(44,152,240, 0.1);
                         }

                        .prodForm_2 {
                            border: 1px solid #9a30ae;
                            background-color: rgba(154,48,174, 0.1);
                        }
                    </style>

                    <section class="panel panel-with-borders">
                        <div class="panel-heading">
                            <h3>Produtos e Serviços</h3>
                        </div>
                        <div class="panel-body">

                            @foreach($product as $p)


                            <section class="panel panel-with-borders prodForm_{{$p['category_id']}}">
                                <div class="panel-heading">
                                    <h5>{{ $p['name'] }}</h5>
                                </div>
                                <div class="panel-body selectProduct_{{ $p['id'] }} categoryId_{{$p['category_id']}}" data-id="{{ $p['id'] }}" data-clicked="0" data-category="{{ $p['category_id'] }}" data-price="{{ $p['values']['value'] }}" style="cursor: pointer;" onclick="addProd('{{ $p['id'] }}')">
                                    <div class="row">
                                        <div class="col-lg-2 col-md-4 col-sm-12 text-center"><img id="img-prod_{{ $p['id'] }}" class="img-responsive img-thumbnail img-circle img-prod" style="width: 150px; height: auto; margin: 0 auto;" src="{{ $p['img'] }}" data-imagesource="{{ $p['img'] }}"></div>
                                        <div class="col-lg-5 col-md-8 col-sm-12">
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

                                                        <span style="font-size: 12px"><b>Em até {{ $maxParcelasCartao }}X de R$ {{ number_format($p['values']['value'] / $maxParcelasCartao, 2, ",", ".") }}</b> <br>

                                                    </span>
                                                </div>
                                            </section>
                                        </div>
                                        -->



                                        <div class="col-lg-5 col-md-12 col-sm-12 text-center">
                                            <section class="panel panel-with-borders" style="min-height: 360px;    margin-top: -37px;">
                                                <div class="panel-body" style="transform: scale(1.5);">
                                                    
                                                    <hr style="margin-top: 5%">
                                                    <h5 style="margin-top: -12px;"><img src="https://cdn0.iconfinder.com/data/icons/50-payment-system-icons-2/480/Boleto.png" height="30"> BOLETO BANCÁRIO</h5>
                                                    <span style="font-size: 13px;"> À Vista no Boleto @if(isset($valorDescontoAVista)) C/ {{ $descontoAVista*100 }}% de desconto @endif <br><span class="label label-success margin-inline margin-3" style="font-size: 24px">R$ {{ number_format( (isset($valorDescontoAVista)?$valorDescontoAVista:$p['values']['value']) , 2, ",", ".") }}</span></span>
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

                                                    <!--
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

                                                    <span>
                                                        @php
                                                        $max_parcela_desc = 0;
                                                        @endphp
                                                        @if(isset($p['discounts']))
                                                            @foreach($p['discounts'] as $desc)

                                                                @if($desc['maximum_parcels'] > 1)
                                                                    @php
                                                                    if ($desc['maximum_parcels'] > $max_parcela_desc){
                                                                        $max_parcela_desc = $desc['maximum_parcels'];
                                                                        $max_parcela_porc = $desc['value'];
                                                                    }
                                                                    @endphp
                                                                    <span style="font-size: 9px"> ou R$ <b>{{ number_format($p['values']['value'] - (($desc['value'] / 100) * $p['values']['value']), 2, ",", ".") }}</b> em até {{ $desc['maximum_parcels'] }}X com <b>{{ $desc['value'] }}%</b> de desconto </span> <br>
                                                                @endif
                                                            @endforeach
                                                        @endif

                                                        @foreach($p['max_parcels'] as $parc)
                                                            @if($parc['parcelas'] > $max_parcela_desc)
                                                                <span style="font-size: 8px"> ou R$ {{ number_format($p['values']['value'], 2, ",", ".") }} em até {{ $parc['parcelas']}}X com o primeira para {{ date('d/m', strtotime($parc['priPagamento'])) }} </span><br>
                                                            @else
                                                                <span style="font-size: 8px"> ou R$ {{ number_format(($p['values']['value'] - ($max_parcela_porc / 100) * $p['values']['value']), 2, ",", ".") }} em até {{ $parc['parcelas']}}X com o primeira para {{ date('d/m', strtotime($parc['priPagamento'])) }} </span><br>
                                                            @endif
                                                        @endforeach
                                                    </span>
                                                </div>
                                            </section>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-footer">
                                    <div class="row">
                                        <!-- Trigger the modal with a button -->
                                        <div class="col-md-6">
                                            <button type="button" class="btn btn-default btn-block btnAddProd_{{ $p['id'] }}" onclick="addProd('{{ $p['id'] }}')">Adicionar a adesão</button>
                                        </div>
                                        <div class="col-md-6">
                                            <button type="button" class="btn btn-info btn-block" data-toggle="modal" data-target="#myModal_{{ $p['id'] }}">Termo de Adesão</button>
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
                                    unset($descontoAVista, $valorDescontoAVista);
                                @endphp
                                <hr style="border: 2px dashed #999">
                            @endforeach()
                        </div>
                        <div class="panel-footer">

                        </div>
                    </section>


                    <div class="row">
                        <hr>
                        <div class="col-md-12 text-center font-size-18">
                            <input type="checkbox" class="form-group checkbox" name="concordo" {{ @$data["concordo"] == 'on' ? 'checked' : '' }} required="required"> Concordo com todos os termos acimas dos produtos e serviços adquiridos.
                        </div>
                        <div class="clearfix"></div>
                        <hr>
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-success btn-block">Continuar</button>
                        </div>
                    </div>
                </div>

            </section>
            <!-- End -->

        </div>
    </section>




    <script>

        var ids = [];

        function addProd(id) {
            var dataClicked = $('.selectProduct_'+id).data('clicked');
            var price = $('.selectProduct_'+id).data('price');
            if(dataClicked == 0){
                var dataCategoryId = $('.selectProduct_'+id).data('category');
                $('.categoryId_'+dataCategoryId).each( function(index, value) {
                    var _id = $(this).data('id');
                    var _clicked = $(this).data('clicked');
                    if(_clicked == 1 && id != _id){
                        delIds(_id);
                        var _img = $(this).find('.img-prod').data('imagesource');
                        $(this).find('#img-prod_'+_id).attr('src', _img);
                        $('.selectProduct_'+_id).data('clicked','0');
                        $('.selectProduct_'+_id).css('background', 'none');
                        $('.btnAddProd_'+_id).removeClass('btn-success').addClass('btn-default');
                        $('.btnAddProd_'+_id).text('Adicionar a adesão');
                    }
                });
                addIds(id);


                $('.selectProduct_'+id).data('clicked','1');
                $('.selectProduct_'+id).css('background', '#f1f1f1');
                $('.selectProduct_'+id).find('#img-prod_'+id).attr('src', '{{asset('assets/common/img/check_products.jpg')}}');
                $('.btnAddProd_'+id).removeClass('btn-default').addClass('btn-success');
                $('.btnAddProd_'+id).text('Adicionado');
            }else{
                delIds(id)
                var img = $('.selectProduct_'+id).find('.img-prod').data('imagesource');
                $('.selectProduct_'+id).data('clicked','0');
                $('.selectProduct_'+id).css('background', 'none');
                $('.selectProduct_'+id).find('#img-prod_'+id).attr('src', img);
                $('.btnAddProd_'+id).removeClass('btn-success').addClass('btn-default');
                $('.btnAddProd_'+id).text('Adicionar a adesão');
            }
            console.log(ids);
        }

        function addIds(id) {
            $('#inputsHiden').append('<input type="hidden" name="products_and_services[]" value="'+id+'" id="input-hiden-'+id+'">');
            ids.push(id);

        }

        function delIds(id) {
            var index = ids.indexOf(id);
            ids.splice(index, 1);
            $('#input-hiden-'+id).remove();

        }

        $('form').submit(function (event) {

            var course = $('.validCourse').val();

            if(course <= 0){
                alert('Selecione um curso!');
                return false;
            }

            if((ids.length > 0)){
                return true;
            }else{
                alert('Escolha e selecione ao menos um produto e/ou serviço que deseja adquirir!');
                return false;
            }
        });

        @if(@$data['products_and_services'])
            @foreach($data['products_and_services'] as $p)
                addProd({{ $p }});
            @endforeach
        @endif

    </script>

@endsection