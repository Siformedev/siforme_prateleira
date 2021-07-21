@extends('portal.inc.layout')

@section('content')


    <section class="page-content">
        <div class="page-content-inner">

            <div class="col-md-12">
                <section class="panel profile-user-content">
                    <div class="panel-body">
                        <div class="nav-tabs-horizontal">

                            <div class="tab-content padding-vertical-20">

                                <div class="col-lg-12">
                                    <a href="{{route('portal.raffle', ['raffle' => $raffle->id])}}" class="btn btn-default float-left">Voltar</a>
                                    <a target="_blank" href="{{route('portal.raffle.number.print', ['number' => $raffle_numbers->id])}}" class="btn btn-info float-right">Imprimir</a>
                                    <div class="clearfix"></div>

                                </div>
                                {{--<div class="col-md-12">--}}
                                    {{--<!-- Example State Done -->--}}
                                    {{--<div class="step-block step-squared step-default"--}}
                                         {{--style="padding-bottom: 5px; padding-top: 5px;">--}}
                                    {{--<span class="step-digit">--}}
                                        {{--<i class="fa fa-user"><!-- --></i>--}}
                                    {{--</span>--}}
                                        {{--<div class="step-desc">--}}
                                            {{--<span class="step-title">Cadastrar Comprador</span>--}}
                                            {{--<p>Atenção!--}}
                                                {{--<br>--}}
                                                {{--Confira todos os dados antes de cadastrar. Não será possivel alterar após o cadastro ser concluído!--}}
                                            {{--</p>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                    {{--<!-- End Example State Done -->--}}
                                {{--</div>--}}


                                <div class="col-lg-12 margin-top-10"></div>

                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <img src="{{$url}}" style="width: 100%; max-width: 800px;">

                                </div>


                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <hr>
                        <div class="clearfix"></div>
                    </div>
            </div>
    </section>
    </div>

    </div>

    </section>

    @if(Session::has('msg'))
        <script>
            $.notify("{{Session::get('msg')}}", {
                animate: {
                    enter: 'animated zoomInDown',
                    exit: 'animated zoomOutUp'
                },
                type: "success",
                delay: 5000,
                timer: 1000,
            });
        </script>
    @endif

@endsection