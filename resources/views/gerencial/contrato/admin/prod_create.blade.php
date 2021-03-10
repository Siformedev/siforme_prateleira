@extends('gerencial.inc.layout')

@section('content')

    <section class="page-content">
        <div class="page-content-inner">

            <!--  -->
            <section class="panel">
                <div class="panel-heading">
                    <div class="col-md-10">
                        <h3>Cadastrar Novo Produto</h3>
                    </div>
                    <div class="col-md-2">
                    <a href="/gerencial/contrato/admin/{{$contract->id}}/prod" class="btn btn-warning btn-block"><i class="icmn icmn-arrow-left"></i> Voltar</a>
                    </div>
                    <div class="clearfix"></div>
                </div>
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
                    <form method="post" action="{{route('gerencial.contrato.admin.prod.store', ['contract' => $contract->id])}}" enctype="multipart/form-data">
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
                        <div class="col-lg-4">
                            <div class="form-group">
                                {{ Form::label('value', 'Valor') }}
                                {{ Form::text('value', null, array_merge(['class' => 'form-control'])) }}
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-group">
                                {{ Form::label('maximum_parcels' , 'Maximo de Parcelas') }}
                                {{ Form::number('maximum_parcels', null, array_merge(['class' => 'form-control'])) }}
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                {{ Form::label('category_id', 'Categoria') }}
                                {{ Form::select('category_id', $categorias, null, array_merge(['class' => 'form-control', 'id' => 'cpf'])) }}
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                {{ Form::label('reset_igpm', 'Próximo Reajuste IGPM') }}
                                {{ Form::date('reset_igpm', null, array_merge(['class' => 'form-control'])) }}
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="date_start">Início das vendas</label>
                                <input type="datetime-local" class="form-control" name="date_start" value="">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="date_end">Fim das vendas</label>
                                <input type="datetime-local" class="form-control" name="date_end" value="">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                {{ Form::label('limit_per_purchase', 'Limite por Compra') }}
                                {{ Form::number('limit_per_purchase', 1, array_merge(['min'=> '1','class' => 'form-control'])) }}
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                {{ Form::label('limit_per_form', 'Limite por Formando') }}
                                {{ Form::number('limit_per_form', 1, array_merge(['min'=> '1','class' => 'form-control'])) }}
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                {{ Form::label('stock', 'Estoque') }}
                                {{ Form::number('stock', 1, array_merge(['min'=> '1','class' => 'form-control'])) }}
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                {{ Form::label('termo_id', 'Termo') }}
                                {{ Form::select('termo_id', $termos, null, array_merge(['class' => 'form-control', 'id' => 'cpf'])) }}
                            </div>
                        </div>
                        <div class="col-md-12">
                            <hr>
                            <button type="submit" class="btn btn-success btn-block">Cadastrar</button>
                        </div>

                        <div class="clearfix"></div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </section>
            <!-- End  -->



        </div>

    </section>

@endsection