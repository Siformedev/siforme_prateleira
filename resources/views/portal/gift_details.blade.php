@extends('portal.inc.layout')

@section('content')


    <section class="page-content">
        <div class="page-content-inner">

            <section class="panel">
                <div class="panel-heading">
                    <a href="{{route('portal.gifts.checkout')}}" class="btn btn-success float-right">CARRINHO (<?php echo count($arrays_cart) ?>)</a> <a href="{{route('portal.gifts')}}" class="btn btn-warning float-right" style="margin-right: 10px;">VOLTAR</a>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">


                        </div>
                    </div>


                    <section class="panel panel-with-borders">
                        <div class="panel-body">
                            <div class="row">

                                <div class="col-lg-4 col-md-12 col-sm-12">
                                    @if($gift->id == 17)
                                        <div class="alert alert-warning">
                                            Formandos que efetuarem a compra da pré-reserva para Maresias e não estiver adimplente com a formatura até o dia 11/10 ás 23:59 terá sua reserva cancelada e o valor reembolsado posteriormente.
                                        </div>
                                    @endif
                                    <div class="col-md-12 text-center"><a href="{{asset('img/portal/gifts/'.$gift->photo)}}" id="lightboxTarget" data-toggle="lightbox" data-gallery="example-gallery"> <img src="{{asset('img/portal/gifts/'.$gift->photo)}}" style="width: 250px;" id="photoVIew"> </a></div>
                                    <div class="col-md-12"><hr></div>

                                    @foreach($gift->photos as $photo)
                                        <div class="col-sm-1 col-md-2 col-lg-3"><img src="{{asset('img/portal/gifts/'.$photo->photo)}}" style="width: 60px; height: 60px;" class="photoGalery"></div>
                                    @endforeach




                                    <br>

                                </div>
                                <div class="col-md-6">
                                    <h1 style="display: block">
                                        {{$gift->name}}

                                    </h1>
                                    <p>{!! $gift->description !!}</p>
                                    <hr>
                                    <p><span class="label label-info" style="font-size: 24px;">R$ {{number_format($gift->price, 2, ',', '.')}}</span> </p>
{{--                                    <hr>--}}
{{--                                    <p style="font-size: 18px;"><span class="label label-important">TAMANHOS:</span> {{$gift->size}}</p>--}}
{{--                                    <p style="font-size: 18px;"><span class="label label-important">MODELOS:</span> {{$gift->models}}</p>--}}
                                    <hr>
                                    <?php
                                    if(in_array($gift->id, $arrays_cart)){
                                    ?>
                                    <div><a class="btn btn-success btn-large">ADICIONADO</a></div>
                                    <?php
                                    }else{
                                    ?>
                                    <div><a href="{{route('portal.gifts.checkout')}}?gift={{$gift->id}}" class="btn btn-default btn-large">ADICIONAR</a></div>
                                    <?php

                                    }
                                    ?>
                                </div>

                            </div>
                        </div>
                    </section>
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

    <script>
        $(document).on('click', '[data-toggle="lightbox"]', function(event) {
            event.preventDefault();
            $(this).ekkoLightbox();
        });

        $(function () {
            $('.photoGalery').click(function () {
                var src = $(this).attr('src');
                $('#photoVIew').attr('src', src);
                $('#lightboxTarget').attr('href', src);
            });
        });
    </script>

@endsection
