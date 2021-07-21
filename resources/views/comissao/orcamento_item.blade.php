@extends('comissao.inc.layout')

@section('content')
    <section class="page-content">
        <div class="page-content-inner">
            <section class="panel">
                <div class="panel-heading">
                    <div class="row">

                        <div class="col-md-7">
                            <h1>Expo Transamérica</h1>
                            <h1><span class="label label-info">R$ 100.000,00</span> - <span class="label label-warning">R$ 25.000,00</span> = <span class="label label-success">R$ 75.000,00</span></h1>
                        </div>
                        <div class="col-md-4">
                            <span>

                            </span>
                        </div>
                        <div class="col-md-1"><a class="btn btn-default" href="{{route('comissao.orcamento')}}">Voltar</a> </div>
                    </>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <h3>Dados dos pagamento realizados</h3>
                        <hr>

                        <div class="row">
                            <div class="col-md-12">

                            </div>

                        </div>
                        <div class="col-lg-12">

                            <br>
                            <div class="margin-bottom-50">
                                <div class="nav-tabs-horizontal">
                                    <ul class="nav nav-tabs" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" href="javascript: void(0);" data-toggle="tab" data-target="#alvo1" role="tab" aria-expanded="true">Pagamentos Realizados</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="javascript: void(0);" data-toggle="tab" data-target="#alvo2" role="tab" aria-expanded="true">Pagamentos Agendados</a>
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
                                                            <table class="table table-hover nowrap dataTable dtr-inline table-data" id="table1">
                                                                <thead>
                                                                <tr>
                                                                    <th>Data</th>
                                                                    <th>Valor</th>
                                                                    <th>Status</th>
                                                                    <th>Comprovante/Contrato</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                @for($i=1; $i<=1; $i++)
                                                                    <tr>
                                                                        <td><span class="font-size-16 font-weight-bold">05/08/2017</span></td>
                                                                        <td><span class="label label-warning">R$25.000</span> </td>
                                                                        <td><span class="label label-success">PAGO</span> </td>
                                                                        <td>
                                                                            <a href="" class="btn btn-info btn-small"><i class="icmn icmn-download5"></i> </a>
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

                                        <div class="tab-pane" id="alvo2" role="tabpanel" aria-expanded="true">
                                            <section class="panel">
                                                <div class="panel-heading">
                                                    <h3><a href=""></a></h3>
                                                </div>
                                                <div class="panel-body">
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <table class="table table-hover nowrap dataTable dtr-inline table-data">
                                                                <thead>
                                                                <tr>
                                                                    <th>Data</th>
                                                                    <th>Valor</th>
                                                                    <th>Status</th>
                                                                    <th>Comprovante</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                @for($i=1; $i<=1; $i++)
                                                                    <tr>
                                                                        <td><span class="font-size-16 font-weight-bold">22/09/2017</span></td>
                                                                        <td><span class="label label-warning">R$25.000</span> </td>
                                                                        <td><span class="label label-default">AGENDADO</span> </td>
                                                                        <td class="font-size-20">
                                                                            <i class="icmn icmn-clock"></i>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><span class="font-size-16 font-weight-bold">22/10/2017</span></td>
                                                                        <td><span class="label label-warning">R$25.000</span> </td>
                                                                        <td><span class="label label-default">AGENDADO</span> </td>
                                                                        <td class="font-size-20">
                                                                            <i class="icmn icmn-clock"></i>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><span class="font-size-16 font-weight-bold">22/11/2017</span></td>
                                                                        <td><span class="label label-warning">R$25.000</span> </td>
                                                                        <td><span class="label label-default">AGENDADO</span> </td>
                                                                        <td class="font-size-20">
                                                                            <i class="icmn icmn-clock"></i>
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
                    </div>
                </div>
                <div class="panel-footer">

                </div>
            </section>
        </div>

    </section>

    <!-- Page Scripts -->
    <script>
        $(function(){

            $('table-data').DataTable({
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

    <script>
        $(function () {
            $('.selectsActives').change(function () {
                var prodId = $('#prodId').val();
                var qt = $('#selectQuantidade').val();
                var dia = $('#diaPagamento').val();
                window.location = '/portal/comprasextras/'+prodId+'/'+qt+'/'+dia;
            });
        });
    </script>

@endsection