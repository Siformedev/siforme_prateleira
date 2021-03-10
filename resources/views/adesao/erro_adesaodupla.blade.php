@extends('adesao.inc.layout')

@section('content')


    <section class="page-content">
        <div class="page-content-inner">

            <!-- Basic Form Elements -->
            <section class="panel">
                <div class="panel-heading">
                    <h3 class="text-center">Atenção! <br> Formando já cadastrado!</h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <img src="{{asset('/assets/common/img/sign_warning.png')}}" style="width: 200px;">
                        </div>
                        <div class="col-md-12">
                            <hr>
                        </div>
                        <div class="col-md-12 text-center">
                            <blockquote class="blockquote-left">
                                <p>Foi identificado que já existe um cadastro utilizando este e-mail ou CPF.</p>
                                <p>Caso não lembre sua senha, utilize o botão "Esqueceu sua senha".</p>
                                <p><a href="{{env('APP_URL')}}/login" style="font-weight: bold; color: red;"> Clique aqui</a> para realizar seu login.</p>
                                <div class="blockquote-footer">
                                </div>
                            </blockquote>
                        </div>
                    </div>


                </div>
            </section>
        </div>


    </section>

@endsection

@php
    session()->flush();
@endphp