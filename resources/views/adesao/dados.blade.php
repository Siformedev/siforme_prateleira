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
                <div class="panel-body">
                    <div class="row">
                        {!! Form::open(['route' => 'adesao.validdados']) !!}

                        <div class="col-lg-12">
                            <!-- Example State Done -->
                            <div class="step-block step-squared step-default" style="padding-bottom: 5px; padding-top: 5px;">
                                        <span class="step-digit">
                                            <i class="fa fa-user"><!-- --></i>
                                        </span>
                                <div class="step-desc">
                                    <span class="step-title">Dados Pessoais</span>
                                    <p>Dados útilizados na sua adesão</p>
                                </div>
                            </div>
                            <!-- End Example State Done -->
                        </div>


                        <div class="col-lg-12 margin-top-10"></div>


                        <div class="col-lg-4">
                            <div class="form-group">
                                @php
                                    if(isset($register)){$nome = $register['name']; $nome = explode(" ", $nome)[0];}elseif(isset($data['nome'])){$nome = $data['nome'];}else{$nome = null;}
                                @endphp
                                {{ Form::label('nome', 'Nome') }}
                                {{ Form::text('nome', $nome, array_merge(['class' => 'form-control'])) }}
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                @php
                                    if(isset($register)){
                                        $sobrenome = explode(" ", $register['name']);
                                        unset($sobrenome[0]);
                                        $sobrenome = implode(" ", $sobrenome);
                                    }elseif(isset($data['sobrenome'])){
                                        $sobrenome = $data['sobrenome'];
                                    }else{$sobrenome = null;}
                                @endphp
                                {{ Form::label('sobrenome', 'Sobrenome') }}
                                {{ Form::text('sobrenome', $sobrenome, array_merge(['class' => 'form-control'])) }}
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group" id="alertValidCpf">
                                @php
                                    if(isset($register)){$cpf = $register['cpf'];}elseif(isset($data['cpf'])){$cpf = $data['cpf'];}else{$cpf = null;}
                                @endphp
                                {{ Form::label('cpf', 'CPF', array_merge(['id' => 'cpfLabel'])) }}
                                {{ Form::text('cpf', $cpf, array_merge(['class' => 'form-control', 'id' => 'cpf'])) }}
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                {{ Form::label('sexo', 'Sexo') }}
                                {{ Form::select('sexo', ['' => 'Selecione...', 'M' => 'Masculino', 'F'=> 'Feminino'], $data['sexo'], array_merge(['class' => 'form-control', 'id' => 'cpf'])) }}
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                {{ Form::label('data-nascimento', 'Data de Nascimento') }}
                                {{ Form::text('datanascimento', $data['datanascimento'], array_merge(['class' => 'form-control', 'id' => 'datanascimento'])) }}
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                {{ Form::label('rg', 'RG') }}
                                {{ Form::text('rg', $data['rg'], array_merge(['class' => 'form-control'])) }}
                            </div>
                        </div>

                        <div class="clearfix"></div>
                        <hr>

                        <div class="col-lg-12">
                            <!-- Example State Done -->
                            <div class="step-block step-squared step-default" style="padding-bottom: 5px; padding-top: 5px;">
                                        <span class="step-digit">
                                            <i class="fa fa-map-pin"><!-- --></i>
                                        </span>
                                <div class="step-desc">
                                    <span class="step-title">Endereço</span>
                                    <p>Dados de seu endereço</p>
                                </div>
                            </div>
                            <!-- End Example State Done -->
                        </div>

                        <div class="col-lg-12 margin-top-10"></div>

                        <div class="col-lg-3">
                            <div class="form-group">
                                {{ Form::label('cep', 'CEP') }}
                                {{ Form::text('cep', $data['cep'], array_merge(['class' => 'form-control', 'id' => 'cep'])) }}
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                {{ Form::label('logradouro', 'Endereço') }}
                                {{ Form::text('logradouro', $data['logradouro'], array_merge(['class' => 'form-control', 'id' => 'logradouro'])) }}
                            </div>
                        </div>

                        <div class="col-lg-1">
                            <div class="form-group">
                                {{ Form::label('numero', 'Número') }}
                                {{ Form::text('numero', $data['numero'], array_merge(['class' => 'form-control', 'id' => 'numero'])) }}
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                {{ Form::label('complemento', 'Complemento') }}
                                {{ Form::text('complemento', $data['complemento'], array_merge(['class' => 'form-control', 'id' => 'complemento'])) }}
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                {{ Form::label('bairro', 'Bairro') }}
                                {{ Form::text('bairro', $data['bairro'], array_merge(['class' => 'form-control', 'id' => 'bairro'])) }}
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                {{ Form::label('cidade', 'Cidade') }}
                                {{ Form::text('cidade', $data['cidade'], array_merge(['class' => 'form-control', 'id' => 'cidade'])) }}
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                {{ Form::label('estado', 'Estado') }}
                                {{ Form::text('estado', $data['estado'], array_merge(['class' => 'form-control', 'id' => 'estado','maxlength' => '2'])) }}
                            </div>
                        </div>

                        <div class="clearfix"></div>
                        <hr>

                        <div class="col-lg-12">
                            <!-- Example State Done -->
                            <div class="step-block step-squared step-default" style="padding-bottom: 5px; padding-top: 5px;">
                                        <span class="step-digit">
                                            <i class="fa fa-book"><!-- --></i>
                                        </span>
                                <div class="step-desc">
                                    <span class="step-title">Dados de Contato</span>
                                    <p>Dados dos seus meios de contato</p>
                                </div>
                            </div>
                            <!-- End Example State Done -->
                        </div>

                        <div class="col-lg-12 margin-top-10"></div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                @php
                                    if(isset($register)){$email = $register['email'];}elseif(isset($data['email'])){$email = $data['email'];}else{$email = null;}
                                @endphp
                                {{ Form::label('email', 'E-mail') }}
                                {{ Form::email('email', $email, array_merge(['class' => 'form-control', 'id' => 'email'])) }}
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                {{ Form::label('telefone-residencial', 'Telefone Residencial') }}
                                {{ Form::text('telefone-residencial', $data['telefone-residencial'], array_merge(['class' => 'form-control', 'id' => 'telefone-residencial'])) }}
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                @php
                                    if(isset($register)){$cellphone = $register['cellphone'];}elseif(isset($data['telefone-celular'])){$cellphone = $data['telefone-celular'];}else{$cellphone = null;}
                                @endphp
                                {{ Form::label('telefone-celular', 'Telefone Celular') }}
                                {{ Form::text('telefone-celular', $cellphone, array_merge(['class' => 'form-control', 'id' => 'telefone-celular'])) }}
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                {{ Form::label('nome_do_pai', 'Nome do Pai') }}
                                {{ Form::text('nome_do_pai', $data['nome_do_pai'], array_merge(['class' => 'form-control', 'id' => 'nome_do_pai'])) }}
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                {{ Form::label('email_do_pai', 'E-mail do Pai') }}
                                {{ Form::email('email_do_pai', $data['email_do_pai'], array_merge(['class' => 'form-control', 'id' => 'email_do_pai'])) }}
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                {{ Form::label('telefone_celular_pai', 'Telefone Celular do Pai') }}
                                {{ Form::text('telefone_celular_pai', $data['telefone_celular_pai'], array_merge(['class' => 'form-control', 'id' => 'telefone_celular_pai'])) }}
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                {{ Form::label('nome_da_mae', 'Nome da Mãe') }}
                                {{ Form::text('nome_da_mae', $data['nome_da_mae'], array_merge(['class' => 'form-control', 'id' => 'nome_da_mae'])) }}
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                {{ Form::label('email_da_mae', 'E-mail da Mãe') }}
                                {{ Form::email('email_da_mae', $data['email_da_mae'], array_merge(['class' => 'form-control', 'id' => 'email_da_mae'])) }}
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                {{ Form::label('telefone_celular_mae', 'Telefone Celular da Mãe') }}
                                {{ Form::text('telefone_celular_mae', $data['telefone_celular_mae'], array_merge(['class' => 'form-control', 'id' => 'telefone_celular_mae'])) }}
                            </div>
                        </div>


                        <div class="clearfix"></div>
                        <hr>

                        <div class="col-lg-12">
                            <!-- Example State Done -->
                            <div class="step-block step-squared step-default" style="padding-bottom: 5px; padding-top: 5px;">
                                        <span class="step-digit">
                                            <i class="fa fa-bookmark-o"><!-- --></i>
                                        </span>
                                <div class="step-desc">
                                    <span class="step-title">Dados Complementares</span>
                                    <p>Perfil do Formando</p>
                                </div>
                            </div>
                            <!-- End Example State Done -->
                        </div>

                        <div class="col-lg-12 margin-top-10"></div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                {{ Form::label('altura', 'Altura') }}
                                {{ Form::select('altura', $i_altura, $data['altura'], array_merge(['class' => 'form-control', 'id' => 'email_do_pai'])) }}
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                {{ Form::label('camiseta', 'Camiseta') }}
                                {{ Form::select('camiseta', $camiseta, $data['camiseta'], array_merge(['class' => 'form-control', 'id' => 'camiseta'])) }}
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                {{ Form::label('calcado', 'Calçado') }}
                                {{ Form::select('calcado', $calcado, $data['calcado'], array_merge(['class' => 'form-control', 'id' => 'calcado'])) }}
                            </div>
                        </div>

                        <div class="clearfix"></div>
                        <hr>

                        <div class="col-md-12">
                            <button type="submit" class="btn btn-success btn-block">Continuar</button>
                        </div>

                        {!! Form::close() !!}

                        </div>
                    </div>
                </div>

            </section>
            <!-- End -->

        </div>
    </section>

    <script>

        function TestaCPF(strCPF) {
            var Soma;
            var Resto;
            Soma = 0;
            if (strCPF == "00000000000") return false;

            for (i=1; i<=9; i++) Soma = Soma + parseInt(strCPF.substring(i-1, i)) * (11 - i);
            Resto = (Soma * 10) % 11;

            if ((Resto == 10) || (Resto == 11))  Resto = 0;
            if (Resto != parseInt(strCPF.substring(9, 10)) ) return false;

            Soma = 0;
            for (i = 1; i <= 10; i++) Soma = Soma + parseInt(strCPF.substring(i-1, i)) * (12 - i);
            Resto = (Soma * 10) % 11;

            if ((Resto == 10) || (Resto == 11))  Resto = 0;
            if (Resto != parseInt(strCPF.substring(10, 11) ) ) return false;
            return true;
        }

        @if(isset($register['cpf']))
        if(!TestaCPF('{{$register['cpf']}}')){
            $('#cpf').val('').addClass('form-control-danger');
            $('#cpfLabel').addClass('label label-danger').html('CPF (Inválido)');
            $('#alertValidCpf').removeClass('label label-success').addClass('has-danger');
        }else{
            $('#cpf').addClass('form-control-success');
            $('#alertValidCpf').addClass('has-success');
            $('#cpfLabel').removeClass('label label-danger').addClass('label label-success').html('CPF (Válido)');
        }
        @endif

        $(function() {

            $('#datanascimento').mask("00/00/0000", {placeholder: "__/__/____"});
            $('#cep').mask("00000-000", {placeholder: "_____-___"});
            $('#cpf').mask("000.000.000-00", {placeholder: "___.___.___-__"});

            //Valida CPF
            $("#cpf").blur(function() {
                waitingDialog.show();
                $('#alertValidCpf').removeClass('has-danger').removeClass('has-success');
                var cpf = $(this).val().replace(/\D/g, '');

                if(!TestaCPF(cpf)){
                    $('#cpf').val('').addClass('form-control-danger');
                    $('#cpfLabel').addClass('label label-danger').html('CPF (Inválido)');
                    $('#alertValidCpf').removeClass('label label-success').addClass('has-danger');
                    //alert('Este número de CPF não é valido!');
                    waitingDialog.hide();
                }else{
                    $('#cpf').addClass('form-control-success');
                    $('#alertValidCpf').addClass('has-success');
                    $('#cpfLabel').removeClass('label label-danger').addClass('label label-success').html('CPF (Válido)');
                    waitingDialog.hide();
                }
            });


            function limpa_formulário_cep() {
                // Limpa valores do formulário de cep.
                $("#logradouro").val("").attr('disabled', true);
                $("#bairro").val("").attr('disabled', true);
                $("#cidade").val("").attr('disabled', true);
                $("#estado").val("").attr('disabled', true);
                $("#numero").val("").attr('disabled', true);
                $("#complemento").val("").attr('disabled', true);
            }

            @if(!isset($data['cep']))
            limpa_formulário_cep();
            @endif

            //Quando o campo cep perde o foco.
            $("#cep").blur(function() {
                waitingDialog.show();

                //Nova variável "cep" somente com dígitos.
                var cep = $(this).val().replace(/\D/g, '');

                //Verifica se campo cep possui valor informado.
                if (cep != "") {

                    //Expressão regular para validar o CEP.
                    var validacep = /^[0-9]{8}$/;

                    //Valida o formato do CEP.
                    if(validacep.test(cep)) {

                        //Preenche os campos com "..." enquanto consulta webservice.
                        $("#logradouro").val("...");
                        $("#bairro").val("...");
                        $("#cidade").val("...");
                        $("#estado").val("...");

                        //Consulta o webservice viacep.com.br/
                        $.getJSON("//viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {

                            if (!("erro" in dados)) {
                                //Atualiza os campos com os valores da consulta.
                                $("#logradouro").val(dados.logradouro).attr('disabled', false);
                                $("#bairro").val(dados.bairro).attr('disabled', false);
                                $("#cidade").val(dados.localidade).attr('disabled', false);
                                $("#estado").val(dados.uf).attr('disabled', false);
                                $("#numero").attr('disabled', false);
                                $("#complemento").attr('disabled', false);

                                waitingDialog.hide();
                            } //end if.
                            else {
                                //CEP pesquisado não foi encontrado.
                                limpa_formulário_cep();
                                alert("CEP não encontrado.");

                                waitingDialog.hide();
                            }
                        });
                    } //end if.
                    else {
                        //cep é inválido.
                        limpa_formulário_cep();
                        alert("Formato de CEP inválido.");

                        waitingDialog.hide();
                    }
                } //end if.
                else {
                    //cep sem valor, limpa formulário.
                    limpa_formulário_cep();

                    waitingDialog.hide();
                }
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
                    '</div>' +
                    '</div></div></div>');

                return {
                    /**
                     * Opens our dialog
                     * @param message Custom message
                     * @param options Custom options:
                     * 				  options.dialogSize - bootstrap postfix for dialog size, e.g. "sm", "m";
                     * 				  options.progressType - bootstrap postfix for progress bar type, e.g. "success", "warning".
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

@endsection