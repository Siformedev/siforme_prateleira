@extends('gerencial.inc.layout')

@section('content')

<?php

use App\Brindesretirados;

$modelBrindes = new Brindesretirados();
?>
<section class="page-content">
    <div class="page-content-inner">

        <section class="panel">
            <div class="panel-heading">

            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-10">
                        <h1>Cadastrar Brinde</h1>
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

                {!! Form::open(['route' => ['gerencial.brindes.store','idcontract'=>$idcontract,'idantigo'=>$id], 'files' => true]) !!}

                <div class="col-lg-4">
                    <div class="form-group">
                        {{ Form::label('nome', 'Nome') }}
                        {{ Form::text('nome', $objeto->nome, array_merge(['class' => 'form-control'])) }}
                    </div>
                </div>
                <div class="col-lg-12"></div>
                <div class="col-lg-4">
                    <div class="form-group">
                        {{ Form::label('descricao', 'Descrição') }}
                        {{ Form::textarea('descricao', $objeto->descricao, array_merge(['class' => 'form-control'])) }}
                    </div>
                </div>
                <div class="col-lg-12"></div>
                <div class="col-lg-6">
                    <div class="form-group">
                        {{ Form::label('foto', 'Foto') }}
                        {{ Form::file('foto', null, array_merge(['class' => 'form-control'])) }}
                    </div>
                </div>
                <div class='col-lg-12'>
                    @if($objeto->pathfile)
                    <object width="100%" height="400" data="<?= url('/storage/uploads/brindes/'); ?>/<?= $objeto->pathfile; ?>"></object>
                    @endif
                </div>

                <div class="col-md-12">
                    <hr>
                    <button type="submit" class="btn btn-success btn-block">Cadastrar</button>
                </div>

                <div class="clearfix"></div>


                {!! Form::close() !!}

            </div>
        </section>
        @if($objeto)
        <section class="panel">
            <div class="panel-heading">
                <div class="col-md-10">
                    <h3>Retirada de Brindes</h3>
                </div>

                <hr>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-hover nowrap dataTable dtr-inline" id="table1">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Nome</th>
                                    <th>Sobrenome</th>
                                    <th></th>
                                    <th>Ação</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($formings as $formando)
                                <tr>
                                    <td>
                                        <span class="font-size-16 font-weight-bold">{{$formando->id}}</span>
                                    </td>
                                    <td>{{$formando->nome}}</td>
                                    <td>{{$formando->sobrenome}}</td>
                                    <td>
                                        <?php if (!$modelBrindes->procuraBrindeRetiado($objeto->id,$formando->id)) { ?>
                                            <a href="{{route('gerencial.brindesretirados.create', ['brinde'=>$objeto->id,'formando' => $formando->id,'contract_id'=>$objeto->contract_id])}}" class="btn btn-secondary btn-block"><i class="fa fa-check"></i> Marcar como retirado</a>
                                        <?php } else { ?>
                                            Brinde Retirado
                                        <?php } ?>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
        @endif

    </div>
</section>

@endsection