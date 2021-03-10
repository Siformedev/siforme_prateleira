@extends('gerencial.inc.layout')

@section('content')


    <section class="page-content">
        <div class="page-content-inner">

            <section class="panel">
                <div class="panel-heading">

                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-10">
                            <h1>Cadastrar Novo Contrato</h1>
                        </div>
                        <div class="col-md-2">
                            <a href="javascript:window.history.back();" class="btn btn-info btn-block"><i class="icmn icmn-arrow-left"></i> Voltar</a>
                        </div>
                    </div>


                </div>
                <div class="panel-footer">
                </div>
            </section>


            <section class="panel">
                <div class="panel-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {!! Form::open(['route' => ['gerencial.contrato.store']]) !!}

                    <div class="col-lg-12">
                        <div class="form-group">
                            {{ Form::label('name', 'Nome') }}
                            {{ Form::text('name', null, array_merge(['class' => 'form-control'])) }}
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="form-group">
                            {{ Form::label('institution', 'Instituição') }}
                            {{ Form::text('institution', null, array_merge(['class' => 'form-control'])) }}
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="form-group">
                            {{ Form::label('conclusion_month', 'Mês ') }}
                            {{ Form::select('conclusion_month', \App\ConfigApp::MesConclusao(), null, array_merge(['class' => 'form-control', 'id' => 'cpf'])) }}
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="form-group">
                            {{ Form::label('conclusion_year', 'Ano de Conclusão') }}
                            {{ Form::select('conclusion_year', array_merge([0 => 'Selecione...'], \App\ConfigApp::AnosConclusao()), null, array_merge(['class' => 'form-control', 'id' => 'cpf'])) }}
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="form-group">
                            {{ Form::label('signature_date', 'Data de Assinatura do Contrato') }}
                            {{ Form::date('signature_date', null, array_merge(['class' => 'form-control'])) }}
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="form-group">
                            {{ Form::label('birthday_date', 'Data do Próximo Aniversario') }}
                            {{ Form::date('birthday_date', null, array_merge(['class' => 'form-control'])) }}
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="form-group">
                            {{ Form::label('igpm', 'Possui IGPM') }}
                            {{ Form::select('igpm', [1 => 'SIM', 0 => 'NÃO'], null, array_merge(['class' => 'form-control','required'])) }}
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            {{ Form::label('goal', 'Meta') }}
                            {{ Form::number('goal', null, array_merge(['min' => '0','class' => 'form-control','required'])) }}
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="form-group">
                            {{ Form::label('Conta Pague Seguro', 'Conta Pague Seguro') }}
                            {{ Form::select('pseg_acc', \App\AccountPseg::all()->pluck('pseg_email','id'), null, array_merge(['class' => 'form-control'])) }}
                        </div>
                    </div>                    
                    
                    <div class="col-lg-4">
                        <div class="form-group">
                            {{ Form::label('periodos', 'Periodo(s)') }}
                            <small>Segure o CTRL para seleção multipla</small>
                            {{ Form::select('periodos[]', \App\ConfigApp::Periodos(), null, array_merge(['multiple'=>'multiple','class' => 'form-control'])) }}
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="form-group">
                            {{ Form::label('email', 'E-mail da Turma') }}
                            {{ Form::text('email', null, array_merge(['class' => 'form-control'])) }}
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="form-group">
                            {{ Form::label('course', 'Selecione o Curso') }}
                            {{ Form::select('course', \App\Course::all()->pluck('name','id'),null, array_merge(['class' => 'form-control'])) }}
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="form-group">
                            {{ Form::label('code', 'Código da Turma') }}
                            {{ Form::text('code', null, array_merge(['class' => 'form-control'])) }}
                        </div>
                    </div>

                    <div class="col-md-12">
                        <hr>
                        <button type="submit" class="btn btn-success btn-block">Cadastrar</button>
                    </div>

                    <div class="clearfix"></div>


                    {!! Form::close() !!}

                </div>
            </section>



        </div>
    </section>

@endsection