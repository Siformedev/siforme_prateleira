@extends('gerencial.inc.layout')

@section('content')

    <section class="page-content">
        <div class="page-content-inner">

            @if(session()->has('message'))
                <div class="alert alert-success">
                    <ul>
                        <li>{{ session('message') }}</li>
                    </ul>
                </div>
            @endif
            <!--  -->
            <section class="panel">
                <div class="panel-heading">
                    <div class="col-md-10">
                        <h3>Gerenciar Produtos</h3>
                        <h4>{{$contract->name}} - {{$contract->institution}} - {{\App\ConfigApp::MesConclusao()[$contract->conclusion_month]}}/{{$contract->conclusion_year}}</h4>
                        <h5>#{{$contract->code}}</h5>
                    </div>
                    <div class="col-md-2">
                        <a href="{{route('gerencial.contrato.admin.prod.create', ['contract' => $contract->id])}}" class="btn btn-info btn-block"><i class="icmn icmn-plus"></i> Novo Produto</a>
                        <a href="javascript:window.history.back();" class="btn btn-warning btn-block"><i class="icmn icmn-arrow-left"></i> Voltar</a>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-body">
                </div>
            </section>
            <!-- End  -->

            <!--  -->
            @foreach($produtos as $p)
                <section class="panel panel-with-borders">
                    <div class="panel-heading">
                        <h5>{{ $p['name'] }}</h5>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-2"><img id="img-prod_{{ $p['id'] }}" class="img-responsive img-thumbnail img-circle img-prod" style="width: 150px; height: 150px;" src="{{ asset($p['img']) }}"></div>
                            <div class="col-md-8">
                                <p>{!! nl2br($p['description'])  !!}</p>
                            </div>
                            <div class="col-md-2">
                            <div class="col-md-12" style="padding-bottom: 2%">
                                <a href="{{route('gerencial.contrato.admin.prod.edit', ['prod' => $p['id']])}}" class="btn btn-success btn-block">Gerenciar</a>
                            </div>
                            
                            <!--<div class="col-md-12">
                                <a href="{{route('gerencial.contrato.admin.prod.remove', ['prod' => $p['id']])}}" class="btn btn-danger btn-block">Apagar</a>
                            </div>-->
                            </div>
                        </div>
                    </div>
                </section>
            @endforeach()
            <!-- End  -->



        </div>

        <!-- Modal -->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Adicionar Produto</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        {!! Form::open(['route' => ['gerencial.contrato.store']]) !!}
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
                            <div class="col-lg-6">
                                <div class="form-group">
                                    {{ Form::label('value', 'Valor') }}
                                    {{ Form::text('value', null, array_merge(['class' => 'form-control'])) }}
                                </div>
                            </div>
                            <div class="col-lg-6">
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
                            <div class="col-lg-6">
                                <div class="form-group">
                                    {{ Form::label('reset_igpm', 'Próximo Reajuste IGPM') }}
                                    {{ Form::date('reset_igpm', null, array_merge(['class' => 'form-control'])) }}
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    {{ Form::label('date_start', 'Data de Inicio') }}
                                    {{ Form::date('date_start', null, array_merge(['class' => 'form-control'])) }}
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    {{ Form::label('date_end', 'Data Fim') }}
                                    {{ Form::date('date_end', null, array_merge(['class' => 'form-control'])) }}
                                </div>
                            </div>

                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    </div>
                </div>
            </div>
        </div>


    </section>

@endsection