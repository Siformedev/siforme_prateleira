@extends('comissao.inc.layout')

@section('content')


    <section class="page-content">
        <div class="page-content-inner">

            <div class="col-md-12">
                <section class="panel profile-user-content">
                    <div class="panel-body">
                        <div class="nav-tabs-horizontal">
                            {!! Form::open(['route' => ['comissao.chamados.store']]) !!}
                            <div class="tab-content padding-vertical-20">
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <div class="col-md-12">
                                    <!-- Example State Done -->
                                    <div class="step-block step-squared step-default"
                                         style="padding-bottom: 5px; padding-top: 5px;">
                                    <span class="step-digit">
                                        <i class="fa fa-user"><!-- --></i>
                                    </span>
                                        <div class="step-desc">
                                            <span class="step-title">Abrir Novo Chamado</span>
                                            <p>Preencha as informações abaixo em até 48hrs um de nossos atendentes
                                                retornará</p>
                                        </div>
                                    </div>
                                    <!-- End Example State Done -->
                                </div>


                                <div class="col-lg-12 margin-top-10"></div>

                                <div class="col-lg-12">
                                    <div class="form-group">
                                        {{ Form::label('assunto_chamado', 'Assunto') }}
                                        {{ Form::select('assunto_chamado', array_merge([0 => 'Selecione...'], \App\ConfigApp::AssuntosChamados()), null, array_merge(['class' => 'form-control', 'id' => 'cpf'])) }}
                                    </div>
                                </div>


                                <div class="col-lg-12">
                                    <div class="form-group">
                                        {{ Form::label('titulo', 'Titulo') }}
                                        {{ Form::text('titulo', null, array_merge(['class' => 'form-control'])) }}
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="form-group">
                                        {{ Form::label('descricao', 'descricao') }}
                                        {{ Form::textarea('descricao', null, array_merge(['class' => 'form-control'])) }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <hr>
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-success btn-block">Iniciar Atendimento</button>
                        </div>
                        <div class="clearfix"></div>
                        {{ Form::hidden('setor_chamado', 2) }}
                        {!! Form::close() !!}
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