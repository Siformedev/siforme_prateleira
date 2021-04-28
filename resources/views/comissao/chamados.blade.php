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
                            <h1>Chamados</h1>
                        </div>
                        <div class="col-md-2">
                            <a href="{{route('comissao.chamados.abrir')}}" class="btn btn-success">Abrir Novo Chamado</a>
                        </div>
                    </div>


                </div>
                <div class="panel-footer">
                </div>
            </section>

            <div class="col-lg-12">

                <br>
                <div class="margin-bottom-50">
                    <div class="nav-tabs-horizontal">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" href="javascript: void(0);" data-toggle="tab" data-target="#alvo1" role="tab" aria-expanded="true">Atendimentos Abetos</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="javascript: void(0);" data-toggle="tab" data-target="#alvo2" role="tab" aria-expanded="false">Atendimentos Finalizados</a>
                            </li>
                        </ul>
                        <div class="tab-content padding-vertical-20">

                            <div class="tab-pane active" id="alvo1" role="tabpanel" aria-expanded="true">
                                @foreach($chamados_abertos as $chamado)
                                <section class="panel">
                                    <div class="panel-heading">
                                        <h3><a href="{{route('comissao.chamados.show', ['chamado' => $chamado['id']])}}">{{$chamado['titulo']}}</a></h3>
                                    </div>
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-md-1">
                                                <span style="font-size: 50px"><i class="icmn-bullhorn" style="color: green"></i></span>
                                            </div>
                                            <div class="col-md-5">
                                                <b>Descrição:</b> <br>
                                                {{\App\Helpers\StringHelper::limitarTexto(strip_tags(nl2br($chamado['descricao'])), 250)}}

                                            </div>
                                            <div class="col-md-3" style="font-size: 16px;">
                                                <table class="table table-bordered">
                                                    <tr>
                                                        <th scope="row">Assunto:</th>
                                                        <td>{{\App\ConfigApp::AssuntosChamados()[$chamado['assunto_chamado']]}}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Status</th>
                                                        <td>{{\App\ConfigApp::ChamadosStatus()[$chamado['status']]}}</td>
                                                    </tr>
                                                </table>
                                            </div>
                                            <div class="col-md-3" style="font-size: 16px;">
                                                <table class="table table-bordered">
                                                    <tr>
                                                        <th scope="row">Data de abertura:</th>
                                                        <td>{{$chamado['created_at']}}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Data Limite:</th>
                                                        <td>{{$chamado['data_limite']}}</td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                                @endforeach

                            </div>

                            <div class="tab-pane" id="alvo2" role="tabpanel" aria-expanded="false">
                                @foreach($chamados_finalizados as $chamado)
                                    <section class="panel">
                                        <div class="panel-heading">
                                            <h3><a href="{{route('portal.chamados.show', ['chamado' => $chamado['id']])}}">{{$chamado['titulo']}}</a></h3>
                                        </div>
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-md-1">
                                                    <span style="font-size: 50px"><i class="icmn-bullhorn" style="color: grey"></i></span>
                                                </div>
                                                <div class="col-md-5">
                                                    <b>Descrição:</b> <br>
                                                    {!! nl2br($chamado['descricao'])  !!}
                                                </div>
                                                <div class="col-md-3" style="font-size: 16px;">
                                                    <table class="table table-bordered">
                                                        <tr>
                                                            <th scope="row">Assunto:</th>
                                                            <td>{{\App\ConfigApp::AssuntosChamados()[$chamado['assunto_chamado']]}}</td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">Status</th>
                                                            <td>{{\App\ConfigApp::ChamadosStatus()[$chamado['status']]}}</td>
                                                        </tr>
                                                    </table>
                                                </div>
                                                <div class="col-md-3" style="font-size: 16px;">
                                                    <table class="table table-bordered">
                                                        <tr>
                                                            <th scope="row">Data de abertura:</th>
                                                            <td>{{$chamado['created_at']}}</td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">Data Limite:</th>
                                                            <td>{{$chamado['data_limite']}}</td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </section>
                                @endforeach
                            </div>

                        </div>
                    </div>
                </div>
            </div>










        </div>
    </section>

@endsection