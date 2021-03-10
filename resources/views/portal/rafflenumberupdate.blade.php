@extends('portal.inc.layout')

@section('content')


    <section class="page-content">
        <div class="page-content-inner">

            <div class="col-md-12">
                <section class="panel profile-user-content">
                    <div class="panel-body">
                        <div class="nav-tabs-horizontal">
                            {!! Form::open(['url' => [route('portal.raffle.number.upstore', ['number' => $raffle_numbers->id])]]) !!}
                            <div class="tab-content padding-vertical-20">


                                <div class="col-md-12">
                                    <!-- Example State Done -->
                                    <div class="step-block step-squared step-default"
                                         style="padding-bottom: 5px; padding-top: 5px;">
                                    <span class="step-digit">
                                        <i class="fa fa-user"><!-- --></i>
                                    </span>
                                        <div class="step-desc">
                                            <span class="step-title">Cadastrar Comprador</span>
                                            <p>Atenção!
                                                <br>
                                                Confira todos os dados antes de cadastrar. Não será possivel alterar
                                                após o cadastro ser concluído!
                                            </p>
                                        </div>
                                    </div>
                                    <!-- End Example State Done -->
                                </div>


                                <div class="col-lg-12 margin-top-10"></div>

                                <div class="col-lg-12" style="text-align: center">
                                    <hr>
                                    <div class="form-group label label-success" style="font-size: 28px;">
                                        Número: <b>{{str_pad($raffle_numbers->number, 5, '0', STR_PAD_LEFT)}}</b>
                                    </div>
                                    <hr>
                                    @if ($errors->any())
                                        <div class="alert alert-danger">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                </div>


                                <div class="col-lg-12">
                                    <div class="form-group">
                                        {{ Form::label('buyer_name', 'Nome do Comprador') }}
                                        {{ Form::text('buyer_name', null, array_merge(['class' => 'form-control'])) }}
                                    </div>
                                </div>


                                <div class="col-lg-12">
                                    <div class="form-group">
                                        {{ Form::label('buyer_phone', 'Celular') }}
                                        {{ Form::text('buyer_phone', null, array_merge(['class' => 'form-control'])) }}
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        {{ Form::label('buyer_email', 'Email') }}
                                        {{ Form::email('buyer_email', null, array_merge(['class' => 'form-control'])) }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <hr>
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-success btn-block" id="Confirm">Confirmar cadastro
                            </button>
                        </div>
                        <div class="clearfix"></div>
                        {!! Form::close() !!}
                    </div>
            </div>
        </div>
    </section>

    <script>

        $("#Confirm").click(function () {
            $(this).attr('disabled', true).text('Cadastrando, favor aguarde...');
            $('form').submit();
        });

    </script>

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