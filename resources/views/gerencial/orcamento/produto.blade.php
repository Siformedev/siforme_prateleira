@extends('gerencial.inc.layout')

@section('content')
    <section class="page-content">
        <div class="page-content-inner">
            <section class="panel">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-2"><img class="img-responsive img-thumbnail img-circle img-prod"
                                                   style="width: 150px; height: 150px;"
                                                   src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS1PTYpv6mWJJY8skZJibap6xMqxZg2o4llZCMeiSk19iW-qscw">
                        </div>
                        <div class="col-md-5">
                            <h3>Cadastro de Produto</h3>
                        </div>
                        <div class="col-md-5">
                            <span>

                            </span>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-body">
                    <form method="post" action="" enctype="multipart/form-data">
                        {!! csrf_field() !!}
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    {{ Form::label('name', 'Nome') }}
                                    {{ Form::text('name', null, array_merge(['class' => 'form-control'])) }}
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    {{ Form::label('img', 'Imagem') }}
                                    {{ Form::file('img', null, array_merge(['class' => 'form-control'])) }}
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    {{ Form::label('description', 'Descrição') }}
                                    {{ Form::textarea('description', null, array_merge(['class' => 'form-control'])) }}
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    {{ Form::label('value', 'Valor') }}
                                    {{ Form::text('value', null, array_merge(['class' => 'form-control'])) }}
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    {{ Form::label('value', 'Valor Minimo') }}
                                    {{ Form::text('value', null, array_merge(['class' => 'form-control'])) }}
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    {{ Form::label('category_id', 'Categoria') }}
                                    {{ Form::select('category_id', $categorias, null, array_merge(['class' => 'form-control', 'id' => 'cpf'])) }}
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    {{ Form::label('maximum_parcels' , 'Proporção por Pessoa') }}
                                    {{ Form::number('maximum_parcels', null, array_merge(['class' => 'form-control'])) }}
                                </div>
                            </div>


                            <div class="clearfix"></div>
                            <hr>
                            <h5>Multiplicadores</h5>
                            <div class="col-lg-3">

                                <div class="form-group">
                                    <label class="text-center display-block"><span class="label label-success display-block">Formandos</span></label>
                                    {{ Form::select('category_id', ['0' => 'Não', '1' => 'Sim'], null, array_merge(['class' => 'form-control', 'id' => 'cpf'])) }}
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label class="text-center display-block"><span class="label label-warning display-block">Convites</span></label>
                                    {{ Form::select('category_id', ['0' => 'Não', '1' => 'Sim'], null, array_merge(['class' => 'form-control', 'id' => 'cpf'])) }}
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label class="text-center display-block"><span class="label label-info display-block">Convites Extras</span></label>
                                    {{ Form::select('category_id', ['0' => 'Não', '1' => 'Sim'], null, array_merge(['class' => 'form-control', 'id' => 'cpf'])) }}
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label class="text-center display-block"><span class="label label-danger display-block">Mesas Extras</span></label>
                                    {{ Form::select('category_id', ['0' => 'Não', '1' => 'Sim'], null, array_merge(['class' => 'form-control', 'id' => 'cpf'])) }}
                                </div>
                            </div>

                            <div class="clearfix"></div>
                            <hr>
                            <h5>Observações</h5>

                            <div class="col-lg-12">
                                <div class="form-group">
                                    {{ Form::textarea('description', null, array_merge(['class' => 'form-control'])) }}
                                </div>
                            </div>


                            <div class="col-md-12">
                                <hr>
                                <button type="submit" class="btn btn-success btn-block">Cadastrar</button>
                            </div>

                            <div class="clearfix"></div>
                            {!! Form::close() !!}
                        </div>

                        <hr>

                    {!! Form::close() !!}


                </div>
                <div class="panel-footer">

                </div>
            </section>
        </div>

    </section>

@endsection