@extends('gerencial.inc.layout')

@section('content')

    <section class="page-content">
        <div class="page-content-inner">

            <!--  -->
            <section class="panel">
                <div class="panel-heading">
                    <div class="col-md-10">
                        <h3>Extrato Financeiro</h3>
                        <h4>{{$contract->name}} - {{$contract->institution}} - {{\App\ConfigApp::MesConclusao()[$contract->conclusion_month]}}/{{$contract->conclusion_year}}</h4>
                        <h5>#{{$contract->code}}</h5>
                    </div>
                    <div class="col-md-2">
                        <a href="javascript:window.history.back();" class="btn btn-info btn-block"><i class="icmn icmn-arrow-left"></i> Voltar</a>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-body">
                </div>
            </section>
            <!-- End  -->

            <!--  -->
            <section class="panel">
                <div class="panel-body">
                    <table class="table table-hover nowrap dataTable dtr-inline" id="table1">
                        <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Valor</th>
                            <th>Pago Boleto</th>
                            <th>Pago Cartão</th>
                            <th>Taxa</th>
                            <th>Total Pago</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $sumTaxa = 0;
                        $sumBoleto = 0;
                        $sumCartao = 0;
                        ?>
                        @foreach($formings_data as $forming)
                            <?php
                                    if(isset($forming['taxa']) && $forming['taxa'] > 0){

                                        $sumTaxa+= $forming['taxa'];
                                    }

                                    if(isset($forming['pgs']['App\PagamentosBoleto'])){
                                        $sumBoleto += $forming['pgs']['App\PagamentosBoleto'];
                                    }

                                    if(isset($forming['pgs']['App\PagamentosCartao'])){
                                        $sumCartao += $forming['pgs']['App\PagamentosCartao'];
                                    }

                                   
                            ?>
                            
                            <tr>
                                <td><span class="font-size-16 font-weight-bold">{{$forming['nome']}}</span></td>
                                <td>R$ {{number_format($forming['parcela'], 2, ",", ".")}}</td>
                                @if(isset($forming['pgs']['App\PagamentosBoleto']))
                                    <td>R$ {{number_format($forming['pgs']['App\PagamentosBoleto'], 2, ",", ".")}}</td>
                                @else
                                    <td>R$ 0,00</td>
                                @endif
                                @if(isset($forming['pgs']['App\PagamentosCartao']))
                                    <td>R$ {{number_format($forming['pgs']['App\PagamentosCartao'], 2, ",", ".")}}</td>
                                @else
                                    <td>R$ 0,00</td>
                                @endif
                                @if(isset($forming['taxa']))
                                    <td>R$ {{number_format($forming['taxa'], 2, ",", ".")}}</td>
                                @else
                                    <td>R$ 0,00</td>
                                @endif
                                <td>R$ {{number_format($forming['pago'], 2, ",", ".")}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td><b>TOTAL</b></td>
                                <td><b>R$ {{number_format($total['parcela'], 2, ",", ".")}}</b></td>
                                <td><b>R$ {{number_format($sumBoleto, 2, ",", ".")}}</b></td>
                                <td><b>R$ {{number_format($sumCartao, 2, ",", ".")}}</b></td>
                                <td><b>R$ {{number_format($sumTaxa, 2, ",", ".")}}</b></td>
                                <td><b>R$ {{number_format($total['pago'], 2, ",", ".")}}</b></td>
                            </tr>
                        </tfoot>
                    </table>
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
                    "order": '',
                    "pageLength": 500
                });
            });
        </script>
        <!-- End Page Scripts -->

    </section>

@endsection