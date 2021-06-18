@extends('gerencial.inc.layout')
@section('content')
<?php

//dump($product);


use \app\Helpers\MainHelper;

$helper = new MainHelper();

//toMysqlDate($data, $paraobanco = true)

?>
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
                <form method="post" action="{{route('gerencial.contrato.admin.prod.store', ['contract' => $contract->id,'idproduct'=>($product ? $product->id:0)])}}" enctype="multipart/form-data">
                    {!! csrf_field() !!}
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                {{ Form::label('name', 'Nome') }}
                                {{ Form::text('name',($product ? $product->name:null), array_merge(['class' => 'form-control'])) }}
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
                                {{ Form::textarea('description', ($product ? $product->description:null), array_merge(['class' => 'form-control'])) }}
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                {{ Form::label('value', 'Valor') }}
                                {{ Form::text('value', ($product ? $product->value:null), array_merge(['class' => 'form-control moeda'])) }}
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-group">
                                {{ Form::label('maximum_parcels' , 'Maximo de Parcelas') }}
                                {{ Form::number('maximum_parcels', ($product ? $product->maximum_parcels:null), array_merge(['class' => 'form-control'])) }}
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                {{ Form::label('category_id', 'Categoria') }}
                                {{ Form::select('category_id', $categorias, ($product ? $product->category_id:null), array_merge(['class' => 'form-control', 'id' => 'cpf'])) }}
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                {{ Form::label('reset_igpm', 'Próximo Reajuste IGPM') }}
                                {{ Form::date('reset_igpm', ($product ? $product->reset_igpm:null), array_merge(['class' => 'form-control'])) }}
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="date_start">Início das vendas</label>
                                <input type="datetime-local" class="form-control" name="date_start" value="{{($product ? str_replace(' ','T',$product->date_start):null)}}">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="date_end">Fim das vendas</label>
                                <input type="datetime-local" class="form-control" name="date_end" value="{{($product ? str_replace(' ','T',$product->date_end):null)}}">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                {{ Form::label('limit_per_purchase', 'Limite por Compra') }}
                                {{ Form::number('limit_per_purchase', ($product ? $product->limit_per_purchase:1), array_merge(['min'=> '1','class' => 'form-control'])) }}
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                {{ Form::label('limit_per_form', 'Limite por Formando') }}
                                {{ Form::number('limit_per_form', ($product ? $product->limit_per_form:1), array_merge(['min'=> '1','class' => 'form-control'])) }}
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                {{ Form::label('stock', 'Estoque') }}
                                {{ Form::number('stock', ($product ? $product->stock:1), array_merge(['min'=> '1','class' => 'form-control'])) }}
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                {{ Form::label('termo_id', 'Termo') }}
                                {{ Form::select('termo_id', $termos, ($product ? $product->termo_id:null), array_merge(['class' => 'form-control', 'id' => 'cpf'])) }}
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