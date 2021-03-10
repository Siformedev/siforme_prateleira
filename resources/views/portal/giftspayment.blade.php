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
                            <h1 style="display: block">
                                Checkout/Pagamento

                            </h1>
                        </div>
                    </div>

                    @if(session('gifts.checkout'))
                            <section class="panel panel-with-borders">
                                <div class="panel-body">
                                    <div class="row">

                                        <form action="{{route('portal.gifts.payment.creditprocess')}}" method="post" id="payment-form">
                                            {{csrf_field()}}
                                            <table class="table table-hover nowrap dtr-inline table-responsive" id="table1">
                                                <thead>
                                                <tr class="text-center">
                                                    <td width="10%">Foto</td>
                                                    <td width="25%">Nome</td>
                                                    <td width="10%">Valor</td>
                                                    <td width="10%">Quantidade</td>
                                                    <td width="20%">Tamanho</td>
                                                    <td width="20%">Modelo</td>
                                                    <td width="5%">SUBTOTAL</td>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @php
                                                $total = 0;
                                                @endphp

                                                @foreach(session('gifts.payment') as $p)
                                                    <?php
                                                    $total+= $p['subtotal'];
                                                    ?>
                                                    <tr>
                                                        <td><img src="{{asset('img/portal/gifts/'.$p['photo'])}}" style="width: 70px; height: 70px;"></td>
                                                        <td>{{$p['name']}}</td>
                                                        <td>{{number_format($p['price'],2,',','.')}}</td>
                                                        <td>{{$p['amount']}}</td>
                                                        <td>{{$p['size']}}</td>
                                                        <td>{{$p['models']}}</td>
                                                        <td>{{number_format($p['subtotal'], 2, ',', '.')}}</td>

                                                    </tr>
                                                @endforeach
                                                </tbody>

                                            </table>
                                            <hr>
                                            <table class="table table-active table-condensed">
                                                <tbody>
                                                <tr>
                                                    <td class="text-right"><strong>TOTAL:</strong></td>
                                                    <td><strong>{{number_format($total, 2, ',', '.')}}</strong></td>
                                                </tr>
                                                </tbody>
                                            </table>

                                            @if($free)
                                                <div>
                                                    <button class="btn btn-primary btn-block" type="submit" id="btn-pagar">
                                                        CONCLUIR PEDIDO
                                                    </button>
                                                </div>
                                            @else
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

                                            <hr>

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
                                                    <select name="pay-parcels" class="form-control">
                                                        @for($i=1;$i<=1;$i++)
                                                            <?php $valor_f =  $total/$i; ?>
                                                            <option value="{{$i}}">{{$i}}X de R$ {{number_format($valor_f, 2, ",", ".")}}</option>
                                                        @endfor
                                                    </select>
                                                </div>
                                                <div>
                                                    <button class="btn btn-primary btn-block" type="submit" id="btn-pagar">
                                                        PAGAR
                                                    </button>
                                                </div>
                                            </div>


                                            <input type="hidden" name="token-iugu" id="token">

                                            @endif

                                        </form>

                                    </div>
                                </div>
                            </section>
                    @else
                        <section class="panel panel-with-borders">
                            <div class="panel-heading">
                                <h5>Nenhum produto adicionado até o momento...</h5>
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

    <script type="text/javascript" src="https://js.iugu.com/v2"></script>
    @if(!$free)
    <script type="text/javascript">


        Iugu.setAccountID("40F41AB589CE405D97211899E06F037E");

        jQuery(function ($) {
            $('#payment-form').submit(function (evt) {

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