@extends('gerencial.inc.layout')

@section('content')

    <section class="page-content">
        <div class="page-content-inner">

            <!--  -->
            <section class="panel">
                <div class="panel-heading">
                    <h3>Busca de Formandos</h3>
                    <hr>
                    <form>
                    <input type="text" name="search" class="form-control" value="{{$search}}" placeholder="Buscar por nome, CPF ou email do formando">
                    </form>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-hover nowrap dataTable dtr-inline table-responsive" id="table1">
                                <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>CPF</th>
                                    <th>Contrato</th>
                                    <th>Periodo</th>
                                    <th>Curso</th>
                                    <th>% Pago</th>
                                    <th></th>
                                    <th>Status</th>
                                    <th>Ação</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(isset($formings))
                                    @foreach($formings as $forming)
                                        <?php
                                        if(isset(\App\ConfigApp::Periodos()[$forming->periodo_id])){
                                            $periodo = \App\ConfigApp::Periodos()[$forming->periodo_id];
                                        }else{
                                            $periodo = '';
                                        }
                                        ?>
                                        <tr>
                                            <td><span class="font-size-16 font-weight-bold">{{$forming->nome}} {{$forming->sobrenome}}</span></td>
                                            <td><span class="font-size-16 font-weight-bold">{{$forming->cpf}}</span></td>
                                            <td>{{$forming->contract->institution}}</td>

                                            <td>{{$periodo}}</td>
                                            <td>{{\App\Course::find($forming->curso_id)['name']}}</td>
                                            <td style="width: 20px;">
                                                {{$formingPerc[$forming->id]}}%
                                            </td>
                                            <td style="width: 60px;">
                                                <progress class="progress progress-success" value="{{$formingPerc[$forming->id]}}" max="100">{{$formingPerc[$forming->id]}}%</progress>
                                            </td>
                                            <td><span class="label label-{{$formingLabel[$forming->id]}}">{{$formingStatus[$forming->id]}}</span> </td>
                                            <td>
                                                <a href="{{route('gerencial.formando.show', ['forming' => $forming->id])}}" class="btn btn-success">Visualizar</a>
                                                <a href="{{route('gerencial.formando.login', ['forming' => $forming->id])}}" class="btn btn-info" title="Logar"><i class="icmn-user"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>
            <!-- End  -->

        </div>

        <!-- Page Scripts -->
        <script>
            $(function(){

                $('#table1').DataTable({
                    responsive: true,
                    "oLanguage": {
                        "sEmptyTable": "Nenhum registro encontrado",
                        "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
                        "sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
                        "sInfoFiltered": "(Filtrados de _MAX_ registros)",
                        "sInfoPostFix": "",
                        "sInfoThousands": ".",
                        "sLengthMenu": "_MENU_ resultados por página",
                        "sLoadingRecords": "Carregando...",
                        "sProcessing": "Processando...",
                        "sZeroRecords": "Nenhum registro encontrado",
                        "sSearch": "Pesquisar",
                        "oPaginate": {
                            "sNext": "Próximo",
                            "sPrevious": "Anterior",
                            "sFirst": "Primeiro",
                            "sLast": "Último"
                        },
                        "oAria": {
                            "sSortAscending": ": Ordenar colunas de forma ascendente",
                            "sSortDescending": ": Ordenar colunas de forma descendente"
                        }
                    },
                    "searching": false,
                    "iDisplayLength": 25,
                    paging: true
                });
            });
        </script>
        <!-- End Page Scripts -->
    </section>

@endsection