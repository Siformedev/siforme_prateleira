@extends('gerencial.inc.layout')

@section('content')

    <section class="page-content">
        <div class="page-content-inner">

            <!--  -->
            <section class="panel">
                <div class="panel-heading">
                    <div class="col-md-10">
                        <h3>Listagem de Contratos</h3>
                    </div>
                    <div class="col-md-2">
                        <a href="{{route('gerencial.contrato.create')}}" class="btn btn-success btn-block"><i class="icmn icmn-plus"></i> Novo</a>
                    </div>
                    <hr>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-hover nowrap dataTable dtr-inline" id="table1">
                                <thead>
                                <tr>
                                    <th>Código</th>
                                    <th>Nome</th>
                                    <th>Instituição</th>
                                    <th>Cursos</th>
                                    <th>Conclusão</th>
                                    <th>Ação</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($contracts as $contract)
                                    <tr>
                                        <td><span class="font-size-16 font-weight-bold">{{$contract['code']}}</span></td>
                                        <td>{{$contract['name']}}</td>
                                        <td>{{$contract['institution']}}</td>
                                        <td>#cursos</td>
                                        <td>{{\App\ConfigApp::MesConclusao()[$contract['conclusion_month']]}}/{{$contract['conclusion_year']}}</td>
                                        <td>
                                            <a href="{{route('gerencial.contrato.admin.panel', ['contract' => $contract['id']])}}" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Gerenciar"><i class="icmn icmn-cog"></i> </a>
                                            <a href="{{route('gerencial.contrato.edit', ['contract' => $contract['id']])}}" class="btn btn-info" data-toggle="tooltip" data-placement="top" title="Editar"><i class="icmn icmn-pencil7"></i> </a>
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

                $(function () {
                    $('[data-toggle="tooltip"]').tooltip()
                })

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
                    "order": ''
                });
            });
        </script>
        <!-- End Page Scripts -->
    </section>

@endsection