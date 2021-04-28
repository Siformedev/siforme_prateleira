@extends('comissao.inc.layout')

@section('content')

    <section class="page-content">
        <div class="page-content-inner">

            <!--  -->
            <section class="panel">
                <div class="panel-heading">
                    <h3>Listagem de Vendas</h3>
                    <hr>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-hover nowrap dataTable dtr-inline table-responsive" style="width: 100% !important;" id="table1">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nome</th>
                                    <th>Quants.</th>
                                    <th>Valor</th>
                                    <th>Taxa</th>
                                    <th>Data</th>
                                    <th>Data Recebimento</th>
                                    <th>Valor Liquido</th>
                                    <th>Status</th>
                                    <th>RECEBIDO</th>
                                    <th>#</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php
                                    $i = 1;
                                @endphp
                                @foreach($vendasTratadas as $venda)
                                    @php
                                        $valor_liquido = $venda['total']-$venda['rate'];
                                    @endphp
                                    <tr>
                                        <td class="text-center">#{{$venda['id']}}</td>
                                        <td>{{$venda['forming_name']}}</td>
                                        <td class="text-center">{{$venda['quants']}}</td>
                                        <td class="text-center">{{number_format($venda['total'], 2, ",", ".")}}</td>
                                        <td class="text-center">{{number_format($venda['rate'], 2, ",", ".")}}</td>
                                        <td class="text-center">{{date("d/m/Y H:i", strtotime($venda['created_at']))}}</td>
                                        <td class="text-center">{{date("d/m/Y", strtotime($venda['receiving_date']))}}</td>
                                        <td class="text-center">{{number_format($valor_liquido, 2, ",", ".")}}</td>
                                        <td class="text-center">{{\App\ConfigApp::GiftRequetsStatus()[$venda['status']]}}</td>
                                        <td class="text-center">@if($venda['receiving']) <label class="label label-success">S</label> @else <label class="label label-danger">N</label>  @endif</td>
                                        <td class="text-center"><a href="{{route('comissao.lojinha.venda.detalhes', ['id' => $venda['id']])}}" class="btn btn-warning"><i class="icmn icmn-search"></i> </a> </td>
                                    </tr>
                                    @php
                                        $i++;
                                    @endphp

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
                    "order": [[5, 'desc']],
                    "iDisplayLength": 25,
                    paging: true
                });
            });
        </script>
        <!-- End Page Scripts -->
    </section>

@endsection