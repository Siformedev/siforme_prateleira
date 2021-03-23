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
                    <a href="{{route('portal.gift.requests')}}" class="btn btn-primary-outline">MEUS PEDIDOS</a>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <h1 style="display: block">
                                Lojinha da Turma

                                <a href="{{route('portal.gifts.checkout')}}" class="btn btn-success float-right">CARRINHO (<?php echo count($arrays_cart) ?>)</a>
                            </h1>

                        </div>
                    </div>


                    @if($gifts != null)
                            <section class="panel panel-with-borders">
                                <div class="panel-body">
                                    <div class="row">

                                        @foreach($gifts as $g)
                                        <div class="col-md-2" style="border: 1px solid #b3b3b3; text-align: center; margin-right: 10px; margin-bottom: 10px;">
                                            <div>
                                                <img src="{{asset('img/portal/gifts/'.$g->photo)}}" style="width: 200px; height: 200px;">
                                            </div>
                                            <hr>
                                            <div style="font-size: 18px; font-weight: bold;">{{$g->name}}</div>
                                            <div>{!! str_limit($g->description, 100) !!}</div>
                                            <hr>
                                            <div style="font-size: 18px; font-weight: bold;">R$ {{number_format($g->price,2,',','.')}}</div>
                                            <br>
                                            <div><a href="{{route('portal.gift.details')}}?gift={{$g->id}}" class="btn btn-info btn-large">+ DETALHES</a></div>
                                            <br>
                                            <?php
                                                if(in_array($g->id, $arrays_cart)){
                                                    ?>
                                                    <div><a class="btn btn-success btn-large">ADICIONADO</a></div>
                                                    <?php
                                                }else{
                                                    ?>
                                                    <div><a href="{{route('portal.gifts.checkout')}}?gift={{$g->id}}" class="btn btn-default btn-large">ADICIONAR</a></div>
                                                    <?php

                                            }
                                            ?>

                                            <br>
                                        </div>
                                        @endforeach()

                                    </div>
                                </div>
                            </section>
                    @else
                        <section class="panel panel-with-borders">
                            <div class="panel-heading">
                                <h5>Nenhum produto extra foi cadastrado até o momento...</h5>
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

@endsection