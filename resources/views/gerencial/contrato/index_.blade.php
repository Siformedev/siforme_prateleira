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
                            <h1>Contratos</h1>
                        </div>
                        <div class="col-md-2">
                            <a href="{{route('comissao.chamados.abrir')}}" class="btn btn-success">Novo Chamado</a>
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
                                <a class="nav-link active" href="javascript: void(0);" data-toggle="tab" data-target="#alvo1" role="tab" aria-expanded="true">Contratos Ativos</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="javascript: void(0);" data-toggle="tab" data-target="#alvo2" role="tab" aria-expanded="false">Contratos Inativos</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="javascript: void(0);" data-toggle="tab" data-target="#alvo2" role="tab" aria-expanded="false">Contratos Cancelados</a>
                            </li>
                        </ul>
                        <div class="tab-content padding-vertical-20">

                            <div class="tab-pane active" id="alvo1" role="tabpanel" aria-expanded="true">

                                <section class="panel">
                                    <div class="panel-heading">
                                        <h3></h3>
                                    </div>
                                    <div class="panel-body">

                                    </div>
                                </section>


                            </div>



                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

@endsection