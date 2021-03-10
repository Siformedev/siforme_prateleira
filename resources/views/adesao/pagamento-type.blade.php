@extends('adesao.inc.layout')

@section('content')


    <section class="page-content">

        <div class="page-content-inner margin-top-10">

            <!-- Basic Form Elements -->
            <section class="panel">
                <div class="panel-body">
                    <h3>Selecione a forma de pagamento</h3>
                </div>
            </section>


            <!-- Basic Form Elements -->
            <section>
                <div class="panel-body col-md-6 col-lg-6">
                    <section class="panel panel-with-borders">
                        <div class="panel-heading text-center">
                            <h3>BOLETO</h3>
                        </div>
                        <div class="panel-body text-center">
                            <a href="{{route('adesao.pagamento')}}?paytype=1"><img src="{{asset('img/boleto.png')}}"></a>
                        </div>
                    </section>
                </div>
            </section>

            <!-- Basic Form Elements -->
            <section>
                <div class="panel-body col-md-6 col-lg-6">
                    <section class="panel panel-with-borders">
                        <div class="panel-heading text-center">
                            <h3>CARTÃO DE CRÉDITO</h3>
                        </div>
                        <div class="panel-body text-center">
                            <a href="{{route('adesao.pagamento')}}?paytype=2"><img src="{{asset('img/credit-card.png')}}"></a>
                        </div>
                    </section>
                </div>
            </section>

        </div>

    </section>

    <script>
        var submit = 0;
        $(function () {
            $('#dia_pagamento').change(function () {
                var dia = $(this).val();
                window.location = '/adesao/pagamento/'+dia;
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