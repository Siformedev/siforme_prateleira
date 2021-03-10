@extends('adesao.inc.layout')

@section('content')


    <section class="page-content">
        <div class="page-content-inner">

            <!-- Basic Form Elements -->
            <section class="panel">
                <div class="panel-heading">
                    <h3 class="text-center">Adesão Concluida com Sucesso!</h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <img class="img-thumbnail" src="{{asset('/assets/common/img/adesao.conlcuido.jpg')}}">
                        </div>
                        <div class="col-md-12">
                            <hr>
                        </div>
                        <div class="col-md-12 text-center">
                            <blockquote class="blockquote-left">
                                <p>Foi enviado para seu email, uma senha provisória e as instruções de acesso.</p>
                                <p>Clique <a href="{{env('APP_URL')}}/login">aqui</a> para realizar seu login.</p>
                                <p>Caso tenha problemas para realizar o acesso, favor entre em contato conosco!</p>
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