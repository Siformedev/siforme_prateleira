@extends('comissao.inc.layout')

@section('content')

    <section class="page-content">
        <div class="page-content-inner">

            <!--  -->
            <section class="panel">
                <div class="panel-heading">
                    <h3>Listagem de Formandos</h3>
                    <hr>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-hover nowrap dataTable dtr-inline table-responsive" id="table1">
                                <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>Curso</th>
                                    <th>Periodo</th>
                                    <th>Data e Hora Adesão</th>
                                    <th>% Pago</th>
                                    <th></th>
                                    <th>Status</th>
                                    <th>Ação</th>
                                </tr>
                                </thead>
                                <tbody>
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
                                        <td>{{\App\Course::find($forming->curso_id)['name']}}</td>
                                        <td>{{$periodo}}</td>
                                        <td>{{$forming->created_at}}</td>
                                        <td style="width: 20px;">
                                            {{$formingPerc[$forming->id]}}%
                                        </td>
                                        <td style="width: 60px;">
                                            <progress class="progress progress-success" value="{{$formingPerc[$forming->id]}}" max="100">{{$formingPerc[$forming->id]}}%</progress>
                                        </td>
                                        <td><span class="label label-{{$formingLabel[$forming->id]}}">{{$formingStatus[$forming->id]}}</span> </td>
                                        <td>
                                            <a href="{{route('comissao.formandos.show', ['$forming' => $forming->id])}}" class="btn btn-success">Visualizar</a>
                                        </td>
                                    </tr>
                                    @endforeach
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
                    "iDisplayLength": 25,
                    paging: true
                });
            });
        </script>
        <!-- End Page Scripts -->
    </section>

@endsection
