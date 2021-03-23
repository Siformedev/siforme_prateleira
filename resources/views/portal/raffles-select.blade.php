@extends('portal.inc.layout')

@section('content')

    <section class="page-content">
        <div class="page-content-inner">

            <!--  -->
            <section class="panel">
                <div class="panel-heading">
                    <h3>Lista de rifas</h3>
                    <hr>
                </div>

                <!-- Modal -->
                <div id="myModal_raffle" class="modal fade modal-size-large" role="dialog">
                    <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Regras da Rifa Online Coletiva</h4>
                            </div>
                            <div class="modal-body">
                                <p></p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">OK</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-hover nowrap dataTable dtr-inline table-responsive" id="table1">
                                <thead>
                                <tr>
                                    <th>Data do Sorteio</th>
                                    <th>Prêmio</th>
                                    <th>Números por pessoa</th>
                                    <th>Valor</th>
                                    <th>#</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($raffles as $raffle)
                                    <tr>
                                        <td>{{\Carbon\Carbon::createFromFormat('Y-m-d', $raffle->draw_date)->format('d/m/Y')}}</td>
                                        <td>{{$raffle->premium}}</td>
                                        <td>{{$raffle->numbers_per_person}}</td>
                                        <td>{{number_format($raffle->price, 2, ",", ".")}}</td>
                                        <td> <a class="btn btn-primary" href="{{route('portal.raffle', ['raffle' => $raffle->id])}}">Visualizar números</a> </td>
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