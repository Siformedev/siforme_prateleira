@extends('gerencial.inc.layout')

@section('content')
    <section class="page-content">
        <div class="page-content-inner">
            <section class="panel">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-2"><img class="img-thumbnail img-circle img-prod"
                                                   style="width: 150px; height: 150px;"
                                                   src="data:image/png;base64,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">
                        </div>
                        <div class="col-md-10">
                            <h3>Cadastro de Categoria</h3>
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

                            <div class="col-lg-10">
                                <div class="form-group">
                                    {{ Form::label('category_id', 'Tipo Evento') }}
                                    {{ Form::select('category_id', $categorias, null, array_merge(['class' => 'form-control', 'id' => 'cpf'])) }}
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    {{ Form::label('maximum_parcels' , 'Posição') }}
                                    {{ Form::number('maximum_parcels', null, array_merge(['class' => 'form-control'])) }}
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