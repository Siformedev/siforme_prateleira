@extends('gerencial.inc.layout')

@section('content')


    <section class="page-content">
        <div class="page-content-inner">

            <section class="panel">
                <div class="panel-heading">
                    <h3>{{$chamado['titulo']}}</h3>
                    <div style="float: right"><a class="btn btn-default" href="{{route('gerencial.calleds')}}">Voltar</a> </div>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-1">
                            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS9hAAvkAoU2EEDF8terQ3Bvk--mIQAnihJpcDmL0Wmfy5Czw23" style="width: 100px;">
                        </div>
                        <div class="col-md-11">
                            <b>Descrição:</b> <br>
                            {!! nl2br($chamado['descricao']) !!}
                        </div>
                    </div>

                    <hr>

                    <h3>Dados do Atendimento</h3>

                    <div class="row">
                        <div class="col-md-12" style="font-size: 16px;">
                            <table class="table table-bordered">
                                <tr>
                                    <th scope="row">NOME FORMANDO:</th>
                                    <td>{{$forming->nome}} {{$forming->sobrenome}} (#{{$forming->id}})</td>
                                </tr>
                                <tr>
                                    <th scope="row">TURMA:</th>
                                    <td>{{$forming->contract->name}} - {{$forming->contract->institution}} - {{$forming->contract->conclusion_month}}/{{$forming->contract->conclusion_year}} (#{{$forming->contract->id}})</td>
                                </tr>

                                <tr>
                                    <th scope="row">Data de abertura:</th>
                                    <td>{{$chamado['created_at']}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Data Limite:</th>
                                    <td>{{$chamado['data_limite']}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Assunto</th>
                                    <td>{{\App\ConfigApp::AssuntosChamados()[$chamado['assunto_chamado']]}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Status</th>
                                    <td>{{\App\ConfigApp::ChamadosStatus()[$chamado['status']]}}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <hr>
                    <h3>Mensagens</h3>

                    <div class="row">
                        <div class="col-md-12">
                            @foreach($chamado->conversas()->orderBy('created_at', 'asc')->get() as $conversa)

                                @php
                                    if($conversa->user_id == auth()->user()->id){
                                        $float_msg = 'right';
                                        $float_type = 'success';
                                    }else{
                                        $float_msg = 'left';
                                        $float_type = 'default';
                                    }

                                @endphp
                            <div class="col-md-10" style="float: {{$float_msg}}">
                                <div class="alert alert-{{$float_type}} text-{{$float_msg}}" role="alert">
                                    <strong>{{$conversa->texto}}</strong>
                                    <br><small>{{$conversa->created_at}}</small>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <hr>
                    {!! Form::open(['route' => ['gerencial.called.conversations.store', $chamado->id]]) !!}
                    <div class="row">
                        <div class="col-md-10">
                            {{ Form::text('texto', null, array_merge(['class' => 'form-control', 'maxlength' => '240'])) }}
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-success btn-block">Enviar</button>
                        </div>
                    </div>
                    {!! Form::close() !!}

                </div>
                <div class="panel-footer">

                </div>
            </section>
        </div>

    </section>

    <script type="text/javascript">
        $(function(){

        });
    </script>

@endsection