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
                    <div class="col-md-12">
                        <h3>Gerenciar Tipos de Pagamento</h3>
                        <h4>{{$contract->name}} - {{$contract->institution}} - {{\App\ConfigApp::MesConclusao()[$contract->conclusion_month]}}/{{$contract->conclusion_year}}</h4>
                        <h5>#{{$contract->code}}</h5>
                    </div>
                </div>
                <div class="panel-body">
                    {!! Form::open(['route'=>'gerencial.contrato.admin.store_tipo_pagamento']) !!}
                    {!! Form::hidden('contrato', $contract->id) !!}
                    <br>
                    <br>
                    <br>
                    <hr>
                    <div class="form-group">
                    <blockquote>
                        <h4>Selecione os Tipos de Pagamento que Serão Permitidos:</h4>
                    </blockquote>
                    {!! Form::select('tipo_pagamento', ['c'=>'Cartão de Crédito','b'=>'Boleto Bancário','cb'=>'Cartão e Boleto Bancário'], ['0'=>'Selecione os Tipos de Pagamento'], ['class'=>'form-control']) !!}
                    </div>
                    <div class="form-group">
                    {!! Form::submit('Gravar', ['class'=>'btn btn-primary btn-lg btn-block']) !!}
                    </div>
                    {!! Form::close() !!}

                </div>
            </section>
            <!-- End  -->



        </div>


    </section>

@endsection