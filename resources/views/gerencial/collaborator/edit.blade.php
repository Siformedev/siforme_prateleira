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
                            <h1>Editar Colaborador</h1>
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

                    {!! Form::model($collaborator, ['route' => ['gerencial.collaborator.update', $collaborator->id]]) !!}

                        <div class="col-lg-12">
                            <div class="form-group">
                                {{ Form::label('name', 'Nome') }}
                                {{ Form::text('name', null, array_merge(['class' => 'form-control'])) }}
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="form-group">
                                {{ Form::label('email', 'Email') }}
                                {{ Form::text('email', $collaborator->user->email, array_merge(['class' => 'form-control'])) }}
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="form-group">
                                {{ Form::label('cpf', 'CPF') }}
                                {{ Form::text('cpf', null, array_merge(['class' => 'form-control'])) }}
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="form-group">
                                {{ Form::label('department', 'Departamento') }}
                                {{ Form::select('department', \App\ConfigApp::CollaboratorDepartment(), null, array_merge(['class' => 'form-control'])) }}
                            </div>
                        </div>


                        <div class="col-lg-12">
                            <div class="form-group">
                                {{ Form::label('password', 'Senha') }}
                                {{ Form::password('password', array_merge(['class' => 'form-control'])) }}
                            </div>
                        </div>

                    <div class="col-md-12">
                        <hr>
                        <button type="submit" class="btn btn-success btn-block">Editar</button>
                    </div>

                    <div class="clearfix"></div>


                    {!! Form::close() !!}

                </div>
            </section>



        </div>
    </section>

@endsection