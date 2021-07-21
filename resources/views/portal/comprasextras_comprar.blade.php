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
                        <div class="col-md-2"><img class="img-responsive img-thumbnail img-circle img-prod" style="width: 150px; height: 150px;" src="{{ $product['product']->img }}"></div>
                        <div class="col-md-5">
                            <h3>{{$product['product']->name}}</h3>
                            <h1><span class="label label-success">R$ {{ number_format($product['values']['value'],2, ",", ".") }}</span> @if($quantidade>1) x <span class="label label-warning">{{ number_format($quantidade,0) }}</span> = <span class="label label-info">R$ {{ number_format(($product['values']['value'] * $quantidade),2, ",", ".") }}</span>@endif</h1>
                        </div>
                        <div class="col-md-4">
                            <span>
                               @if(isset($product['discounts']))
                                    <span class="label">Descontos</span><hr>
                                    @foreach($product['discounts'] as $desc)
                                        @if($desc['maximum_parcels'] >= 1)
                                            @if($tipo_pagamento == 'boleto')
                                            <span style="font-size: 9px"> ou R$ <b>{{ number_format($product['values']['value'] - (($desc['value'] / 100) * $product['values']['value']), 2, ",", ".") }}</b> em até {{ $desc['maximum_parcels'] }}X com <b>{{ $desc['value'] }}%</b> de desconto </span> <br>
                                            @else
                                            <span style="font-size: 9px"> ou R$ <b>{{ number_format($product['values']['value'] - (($desc['value_credit_card'] / 100) * $product['values']['value']), 2, ",", ".") }}</b> em até {{ $desc['maximum_parcels'] }}X com <b>{{ $desc['value_credit_card'] }}%</b> de desconto </span> <br>
                                            @endif
                                        @endif
                                    @endforeach
                                @endif
                                <!--
                                <br><br>
                                <span class="label">Parcelamento</span><hr>
                                @foreach($product['max_parcels'] as $parc)
                                    <span style="font-size: 8px"> ou R$ {{ number_format($product['values']['value'], 2, ",", ".") }} em até {{ $parc['parcelas']}}X com o primeira para {{ date('d/m', strtotime($parc['priPagamento'])) }} </span><br>
                                @endforeach
                                   -->
                            </span>
                        </div>
                        <div class="col-md-1"><a class="btn btn-default" href="{{route('portal.comprasextras')}}">Voltar</a> </div>
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

                    @if($product['selectQuantidade'] <= 0)
                        <div class="alert alert-warning">Lote esgostado ou limite excedido!</div>
                    @else


                        <h3>Dados para Compra e Pagamento</h3>
                        {!! Form::open(['route' => 'portal.comprasextras.store']) !!}
                        <div class="row">
                            <hr>
                            <div class="col-md-2">
                                <div class="form-group">
                                    {{ Form::label('quantidade', 'Quantidade') }}
                                    @if($product['selectQuantidade'] == 0)
                                        {{ Form::select('quantidade', ['' => 'Limite excedido'], $quantidade, array_merge(['class' => 'form-control selectsActives', 'id' => 'selectQuantidade'])) }}
                                    @elseif(count($product['selectQuantidade'] )>0)
                                        {{ Form::select('quantidade', $product['selectQuantidade'], $quantidade, array_merge(['class' => 'form-control selectsActives', 'id' => 'selectQuantidade'])) }}
                                    @endif

                                </div>
                            </div>
                            <div class="col-md-3" style="display:none">
                                <div class="form-group">
                                    {{ Form::label('tipo_pagamento', 'Pagamento') }}
                                    {{ Form::select('tipo_pagamento', ['boleto' => 'Boleto', 'credit' => 'Cartão de crédito'], $tipo_pagamento, array_merge(['class' => 'form-control tipo_pagamento'])) }}
                                </div>
                            </div>
                            @if($tipo_pagamento == 'boleto')
                                <div class="col-md-3">
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
                            @elseif($tipo_pagamento == 'credit')
                                <div class="col-md-3" style="font-size: 16px;">

                                    <style>

                                        /* Credit Card Form */
                                        .usable-creditcard-form, .usable-creditcard-form * {
                                            font-size: 13px;
                                        }

                                        .usable-creditcard-form {
                                            position: relative;
                                            padding: 0px;
                                            width: 300px;
                                            margin-left: auto;
                                            margin-right: auto;
                                        }

                                        .usable-creditcard-form .wrapper {
                                            border: 1px solid #CCC;
                                            border-top: 1px solid #AAA;
                                            border-right: 1px solid #AAA;
                                            height: 74px;
                                            width: 300px;
                                            position: relative;
                                            -webkit-border-radius: 5px;
                                            -moz-border-radius: 5px;
                                            border-radius: 5px;
                                        }

                                        .usable-creditcard-form .input-group {
                                            position: absolute;
                                            top: 300px;
                                        }

                                        .usable-creditcard-form .input-group.nmb_a {
                                            position: absolute;
                                            width: 200px;
                                            top: 0px;
                                            left: 0px;
                                        }

                                        .usable-creditcard-form .input-group.nmb_b {
                                            position: absolute;
                                            width: 100px;
                                            top: 0px;
                                            right: 0px;
                                        }

                                        .usable-creditcard-form .input-group.nmb_b input,
                                        .usable-creditcard-form .input-group.nmb_d input {
                                            text-align: center;
                                        }

                                        .usable-creditcard-form .input-group.nmb_c {
                                            position: absolute;
                                            width: 200px;
                                            top: 37px;
                                            left: 0px;
                                        }

                                        .usable-creditcard-form .input-group.nmb_d {
                                            position: absolute;
                                            width: 100px;
                                            top: 37px;
                                            right: 0px;
                                        }

                                        .usable-creditcard-form input {
                                            background: none;
                                            display: block;
                                            width: 100%;
                                            padding: 10px;
                                            -moz-box-sizing: border-box;
                                            -webkit-box-sizing: border-box;
                                            box-sizing: border-box;
                                            margin: 0px;
                                            padding-left: 35px;
                                            border: none;
                                        }

                                        .usable-creditcard-form .input-group .icon {
                                            position: absolute;
                                            width: 22px;
                                            height: 22px;
                                            background: #CCC;
                                            left: 8px;
                                            top: 7px;
                                        }

                                        .usable-creditcard-form .input-group.nmb_a input {
                                            border-right: 1px solid #ECECEC;
                                        }

                                        .usable-creditcard-form .input-group.nmb_c input {
                                            border-top: 1px solid #ECECEC;
                                            border-right: 1px solid #ECECEC;
                                        }

                                        .usable-creditcard-form input::-webkit-input-placeholder {
                                            font-size: 12px;
                                            text-transform: none;
                                        }

                                        .usable-creditcard-form .input-group.nmb_d input {
                                            border-top: 1px solid #ECECEC;
                                        }

                                        .usable-creditcard-form .input-group.nmb_c input {
                                            text-transform: uppercase;
                                        }

                                        .usable-creditcard-form .accept {
                                            color: #999;
                                            font-size: 11px;
                                            margin-bottom: 5px;
                                        }

                                        .usable-creditcard-form .footer {
                                            margin-top: 3px;
                                            position: relative;
                                            margin-left: 5px;
                                            margin-right: 5px;
                                        }

                                        .usable-creditcard-form .footer img {
                                            padding: 0px;
                                            margin: 0px;
                                        }

                                        .usable-creditcard-form .iugu-btn {
                                            position: absolute;
                                            top: 0px;
                                            right: 0px;
                                        }

                                        /* Do not forget to store your images in a secure server */
                                        .usable-creditcard-form .input-group .icon.ccic-name {
                                            background: url("http://storage.pupui.com.br/9CA0F40E971643D1B7C8DE46BBC18396/assets/ccic-name.1cafa1882fdd56f8425de54a5a5bbd1e.png") no-repeat;
                                        }

                                        .usable-creditcard-form .input-group .icon.ccic-exp {
                                            background: url("http://storage.pupui.com.br/9CA0F40E971643D1B7C8DE46BBC18396/assets/ccic-exp.05e708b1489d5e00c871f20ba33bbff3.png") no-repeat;
                                        }

                                        .usable-creditcard-form .input-group .icon.ccic-brand {
                                            background: url("http://storage.pupui.com.br/9CA0F40E971643D1B7C8DE46BBC18396/assets/ccic-brands.48dba03883007f86e118f683dcfc4297.png") no-repeat;
                                        }

                                        .usable-creditcard-form .input-group .icon.ccic-cvv {
                                            background: url("http://storage.pupui.com.br/9CA0F40E971643D1B7C8DE46BBC18396/assets/ccic-cvv.1fe78dcc390427094bdc14dedea10f34.png") no-repeat;
                                        }

                                        .usable-creditcard-form .input-group .icon.ccic-cvv,
                                        .usable-creditcard-form .input-group .icon.ccic-brand {
                                            -webkit-transition: background-position .2s ease-in;
                                            -moz-transition: background-position .2s ease-in;
                                            -o-transition: background-position .2s ease-in;
                                            transition: background-position .2s ease-in;
                                        }

                                        .amex .usable-creditcard-form .input-group .icon.ccic-cvv {
                                            background-position: 0px -22px;
                                        }

                                        .amex .usable-creditcard-form .input-group .icon.ccic-brand {
                                            background-position: 0px -110px;
                                        }

                                        .visa .usable-creditcard-form .input-group .icon.ccic-brand {
                                            background-position: 0px -22px;
                                        }

                                        .diners .usable-creditcard-form .input-group .icon.ccic-brand {
                                            background-position: 0px -88px;
                                        }

                                        .mastercard .usable-creditcard-form .input-group .icon.ccic-brand {
                                            background-position: 0px -66px;
                                        }

                                        /* Non Credit Card Form - Token Area */
                                        .token-area {
                                            margin-top: 20px;
                                            margin-bottom: 20px;
                                            border: 1px dotted #CCC;
                                            display: block;
                                            padding: 20px;
                                            background: #EFEFEF;
                                        }

                                    </style>

                                    <!--
                                    Using Formatter.js - Iugu detecta e melhora o input de Cartão:
                                    http://firstopinion.github.io/formatter.js/
                                    -->

                                    <div class="usable-creditcard-form">
                                        <div class="wrapper">
                                            <div class="input-group nmb_a">
                                                <div class="icon ccic-brand"></div>
                                                <input autocomplete="off" class="credit_card_number" data-iugu="number"
                                                       placeholder="Número do Cartão" type="text" value=""/>
                                            </div>
                                            <div class="input-group nmb_b">
                                                <div class="icon ccic-cvv"></div>
                                                <input autocomplete="off" class="credit_card_cvv"
                                                       data-iugu="verification_value" placeholder="CVV" type="text"
                                                       value=""/>
                                            </div>
                                            <div class="input-group nmb_c">
                                                <div class="icon ccic-name"></div>
                                                <input class="credit_card_name" data-iugu="full_name"
                                                       placeholder="Titular do Cartão" type="text" value=""/>
                                            </div>
                                            <div class="input-group nmb_d">
                                                <div class="icon ccic-exp"></div>
                                                <input autocomplete="off" class="credit_card_expiration"
                                                       data-iugu="expiration" placeholder="MM/AA" type="text" value=""/>
                                            </div>

                                        </div>
                                        <div class="footer">
                                            <img src="http://storage.pupui.com.br/9CA0F40E971643D1B7C8DE46BBC18396/assets/cc-icons.e8f4c6b4db3cc0869fa93ad535acbfe7.png"
                                                 alt="Visa, Master, Diners. Amex" border="0"/>
                                            <a class="iugu-btn" href="http://iugu.com" tabindex="-1"><img
                                                        src="http://storage.pupui.com.br/9CA0F40E971643D1B7C8DE46BBC18396/assets/payments-by-iugu.1df7caaf6958f1b5774579fa807b5e7f.png"
                                                        alt="Pagamentos por Iugu" border="0"/></a>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-control-label">Selecione a quantidade de
                                                parcelas:</label>
                                            <select name="parcelas" class="form-control">
                                                @foreach($product['parcels'] as $key => $value)
                                                    <option value="{{$key}}">{{$value}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>


                                    <input type="hidden" name="token" id="token">


                                    {!! csrf_field() !!}


                                </div>
                            @endif

                            {{ Form::hidden('prodId', $product['product']['id'], ['id' => 'prodId']) }}
                            {{ Form::hidden('tp_pg', $tipo_pagamento) }}
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-success btn-block">CONCORDAR COM O TERMO <br>E FINALIZAR COMPRA</button>
                            </div>
                        </div>
                        {!! Form::close() !!}


                    @endif




                </div>
                <div class="panel-footer">

                </div>
            </section>
        </div>

    </section>

    <script>
        $(function () {
            var tipo_pagamento = '{{$tipo_pagamento}}';
            $('.selectsActives').change(function () {
                var prodId = $('#prodId').val();
                var qt = $('#selectQuantidade').val();
                var dia = $('#diaPagamento').val();
                dia_static = dia;
                if(dia){
                    window.location = '/portal/comprasextras/'+prodId+'/'+qt+'/'+dia+'/'+tipo_pagamento;
                }else{
                    window.location = '/portal/comprasextras/'+prodId+'/'+qt+'/10'+'/'+tipo_pagamento;
                }
            });
            $('#tipo_pagamento').change(function () {

                var tp = $('#tipo_pagamento').val();
                var prodId = $('#prodId').val();
                var qt = $('#selectQuantidade').val();
                var dia = $('#diaPagamento').val();

                window.location = '/portal/comprasextras/'+prodId+'/'+qt+'/10/'+tp;
            });
        });
    </script>

    @if($tipo_pagamento == 'credit')

        <script type="text/javascript" src="https://js.iugu.com/v2"></script>

        <script type="text/javascript">


            Iugu.setAccountID("40F41AB589CE405D97211899E06F037E");
            //Iugu.setTestMode(true);

            jQuery(function ($) {
                $('form').submit(function (evt) {

                    var form = $(this);
                    var tokenResponseHandler = function (data) {

                        if (data.errors) {

                            //alert("Erro salvando cartão: " + JSON.stringify(data.errors));
                            if (data.errors.number) {
                                alert("Número do cartão inválido");
                            } else if (data.errors.verification_value) {
                                alert("Código de segurança inválido");
                            } else if (data.errors.first_name) {
                                alert("Nome inválido");
                            } else if (data.errors.last_name) {
                                alert("Sobrenome inválido");
                            } else if (data.errors.expiration) {
                                alert("Validade inválido");
                            }
                        } else {
                            waitingDialog.show();
                            $("#btn-pagar").attr('disabled', true);
                            $("#token").val(data.id);
                            form.get(0).submit();
                        }

                        // Seu código para continuar a submissão
                        // Ex: form.submit();
                    }

                    Iugu.createPaymentToken(this, tokenResponseHandler);
                    return false;
                });
            });

            /**
             * Module for displaying "Waiting for..." dialog using Bootstrap
             *
             * @author Eugene Maslovich <ehpc@em42.ru>
             */

            var waitingDialog = waitingDialog || (function ($) {
                'use strict';

                // Creating modal dialog's DOM
                var $dialog = $(
                    '<div class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true" style="padding-top:15%; overflow-y:visible;">' +
                    '<div class="modal-dialog modal-m">' +
                    '<div class="modal-content">' +
                    '<div class="modal-header"><h3 style="margin:0;"></h3></div>' +
                    '<div class="modal-body text-center">' +
                    '<img src="{{ asset('assets/common/img/loading.gif') }}">' +
                    '<h1>Processando pagamento</h1>' +
                    '</div>' +
                    '</div></div></div>');

                return {
                    /**
                     * Opens our dialog
                     * @param message Custom message
                     * @param options Custom options:
                     *                  options.dialogSize - bootstrap postfix for dialog size, e.g. "sm", "m";
                     *                  options.progressType - bootstrap postfix for progress bar type, e.g. "success", "warning".
                     */
                    show: function (message, options) {
                        // Assigning defaults
                        if (typeof options === 'undefined') {
                            options = {};
                        }
                        if (typeof message === 'undefined') {
                            message = 'Loading';
                        }
                        var settings = $.extend({
                            dialogSize: 'm',
                            progressType: '',
                            onHide: null // This callback runs after the dialog was hidden
                        }, options);

                        // Configuring dialog
                        $dialog.find('.modal-dialog').attr('class', 'modal-dialog').addClass('modal-' + settings.dialogSize);
                        $dialog.find('.progress-bar').attr('class', 'progress-bar');
                        if (settings.progressType) {
                            $dialog.find('.progress-bar').addClass('progress-bar-' + settings.progressType);
                        }
                        $dialog.find('h3').text(message);
                        // Adding callbacks
                        if (typeof settings.onHide === 'function') {
                            $dialog.off('hidden.bs.modal').on('hidden.bs.modal', function (e) {
                                settings.onHide.call($dialog);
                            });
                        }
                        // Opening dialog
                        $dialog.modal();
                    },
                    /**
                     * Closes dialog
                     */
                    hide: function () {
                        $dialog.modal('hide');
                    }
                };

            })(jQuery);

        </script>

    @endif



@endsection
