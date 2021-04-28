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



    </div>
</section>

@endsection