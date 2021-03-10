@extends('comissao.inc.layout')

@section('content')


    <section class="page-content">
        <div class="page-content-inner">

            <section class="panel">
                <div class="panel-heading">

                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-10">
                            <h1>Orçamento - <b>POLI TURMA 2018</b></h1>
                        </div>
                        <div class="col-md-2">
                            <a href="{{ route('comissao.chamados.abrir') }}" class="btn btn-success">Abrir Chamado</a>
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
                                <a class="nav-link active" href="javascript: void(0);" data-toggle="tab" data-target="#alvo1" role="tab" aria-expanded="true">Listagem do Orçamento</a>
                            </li>
                        </ul>
                        <div class="tab-content padding-vertical-20">

                            <div class="tab-pane active" id="alvo1" role="tabpanel" aria-expanded="true">
                                <section class="panel">
                                    <div class="panel-heading">
                                        <h3><a href=""></a></h3>
                                    </div>
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <table class="table table-hover nowrap dataTable dtr-inline" id="table1">
                                                    <thead>
                                                    <tr>
                                                        <th>Nome</th>
                                                        <th>Categoria</th>
                                                        <th>Valor Orçado</th>
                                                        <th>Valor Já Pago</th>
                                                        <th>% Pago</th>
                                                        <th>Saldo</th>
                                                        <th>Ação</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @for($i=1; $i<=2; $i++)
                                                        <tr>
                                                            <td><span class="font-size-16 font-weight-bold">Expo Transamérica</span></td>
                                                            <td>Local</td>
                                                            <td><span class="label label-default">R$100.000</span></td>
                                                            <td><span class="label label-warning">R$25.000</span> </td>
                                                            <td>
                                                                <progress class="progress progress-success" value="25" max="100">25%</progress>
                                                            </td>
                                                            <td><span class="label label-success">R$75.000</span> </td>
                                                            <td>
                                                                <a href="{{route('comissao.orcamento.item')}}" class="btn btn-info btn-small"><i class="icmn icmn-zoom-in"></i> </a>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td><span class="font-size-16 font-weight-bold">ECAD</span></td>
                                                            <td>Local</td>
                                                            <td><span class="label label-default">R$10.000</span></td>
                                                            <td><span class="label label-warning">R$2.000</span> </td>
                                                            <td>
                                                                <progress class="progress progress-success" value="20" max="100">20%</progress>
                                                            </td>
                                                            <td><span class="label label-success">R$8.000</span> </td>
                                                            <td>
                                                                <a href="" class="btn btn-info btn-small"><i class="icmn icmn-zoom-in"></i> </a>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td><span class="font-size-16 font-weight-bold">Dj de Formatura</span></td>
                                                            <td>Local</td>
                                                            <td><span class="label label-default">R$1.000</span></td>
                                                            <td><span class="label label-warning">R$1.500</span> </td>
                                                            <td>
                                                                <progress class="progress progress-danger" value="150" max="100">150%</progress>
                                                            </td>
                                                            <td><span class="label label-danger">R$-500</span> </td>
                                                            <td>
                                                                <a href="" class="btn btn-info btn-small"><i class="icmn icmn-zoom-in"></i> </a>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td><span class="font-size-16 font-weight-bold">Decoração</span></td>
                                                            <td>Local</td>
                                                            <td><span class="label label-default">R$110.000</span></td>
                                                            <td><span class="label label-warning">R$11.000</span> </td>
                                                            <td>
                                                                <progress class="progress progress-success" value="10" max="100">100%</progress>
                                                            </td>
                                                            <td><span class="label label-danger">R$99.000</span> </td>
                                                            <td>
                                                                <a href="" class="btn btn-info btn-small"><i class="icmn icmn-zoom-in"></i> </a>
                                                            </td>
                                                        </tr>
                                                    @endfor
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </section>

                            </div>

                        </div>
                    </div>
                </div>
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
                        "order": '',
                        "footerCallback": function (row, data, start, end, display) {
                            var api = this.api(),
                                intVal = function (i) {
                                    return typeof i === 'string' ?
                                        i.replace(/[, Rs]|(\.\d{2})/g,"")* 1 :
                                        typeof i === 'number' ?
                                            i : 0;
                                },
                                total2 = api
                                    .column(4)
                                    .data()
                                    .reduce(function (a, b) {
                                        return intVal(a) + intVal(b);
                                    }, 0);

                            $(api.column(4).footer()).html(
                                ' ( $' + total2 + ' total)'
                            );
                        }
                    });
                });
            </script>
            <!-- End Page Scripts -->

        </div>
    </section>

@endsection