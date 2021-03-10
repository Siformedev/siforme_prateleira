@extends('gerencial.inc.layout')

@section('content')

    <section class="page-content">
        <div class="page-content-inner">

            <!-- Dashboard -->
            <div class="dashboard-container">

                @if (Session::has('msg_success'))
                    <div class="alert alert-success">
                        <ul>
                            <li>{{ Session::get('msg_success') }}</li>
                        </ul>
                    </div>
                @endif

                <div class="row">
                    <div class="col-xl-4 col-lg-6 col-sm-6 col-xs-12">
                        <div class="widget widget-seven background-info">
                            <div class="widget-body">
                                <div href="javascript: void(0);" class="widget-body-inner">
                                    <h5 class="text-uppercase">TOTAL</h5>
                                    <i class="counter-icon icmn-coin-dollar"></i>
                                    <span class="counter-count">
                                {{number_format($sum['total'],2,",",".")}}
                            </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-6 col-sm-6 col-xs-12">
                        <div class="widget widget-seven background-warning">
                            <div class="widget-body">
                                <div href="javascript: void(0);" class="widget-body-inner">
                                    <h5 class="text-uppercase">PAGO</h5>
                                    <i class="counter-icon icmn-coin-dollar"></i>
                                    <span class="counter-count">
                                        {{number_format($sum['paid'],2,",",".")}}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-6 col-sm-6 col-xs-12">
                        <div class="widget widget-seven background-default">
                            <div class="widget-body">
                                <div href="javascript: void(0);" class="widget-body-inner">
                                    <h5 class="text-uppercase">AGENDADOS</h5>
                                    <i class="counter-icon icmn-coin-dollar"></i>
                                    <span class="counter-count">
                                        {{number_format($sum['not_paid'],2,",",".")}}
                            </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>

                <div class="row">
                    <div class="col-md-12">

                        <br>
                        <a href="{{route('gerencial.contrato.expenses.create', ['contract' => $contract])}}"
                           class="btn btn-info float-right">Nova Despesa</a>
                        <div class="margin-bottom-50">
                            <div class="nav-tabs-horizontal">
                                <ul class="nav nav-tabs" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" href="javascript: void(0);" data-toggle="tab"
                                           data-target="#alvo1" role="tab" aria-expanded="true">Últimas Despesas</a>
                                    </li>
                                </ul>
                                <div class="tab-content padding-vertical-20">

                                    <div class="tab-pane active" id="alvo1" role="tabpanel" aria-expanded="true">
                                        <table class="table table-hover dataTable table-responsive"
                                               id="table1" style="width: 100% !important;">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Nome</th>
                                                <th><i class="fa fa-info"></i></th>
                                                <th>Data de vencimento</th>
                                                <th>Valor</th>
                                                <th>Pago</th>
                                                <th>Data de pagamento</th>
                                                <th>Anexo Despesa</th>
                                                <th>Anexo Pagamento</th>
                                                <th>#</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @php
                                                $i = 1;
                                            @endphp
                                            @if(isset($contract->expenses))
                                                @foreach($contract->expenses as $expense)
                                                    <tr>
                                                        <td>#{{$expense['id']}}</td>
                                                        <td>{{$expense['name']}}</td>
                                                        <td class="text-center">
                                                            @if(!empty($expense['description']))
                                                                <i class="fa fa-question-circle-o" title="" data-container="body" data-toggle="popover-hover" data-placement="top" data-content="{{$expense['description']}}" data-original-title="Descrição" style="font-size: 20px; color: orange">
                                                                </i>
                                                            @endif
                                                        </td>
                                                        <td class="text-center">{{date("d/m/Y", strtotime($expense['due_date']))}}</td>
                                                        <td>{{number_format($expense['value'], 2, ",", ".")}}</td>
                                                        <td class="text-center">
                                                            @if($expense->paid == 1)
                                                                <i class="fa fa-check-circle fa-2x" style="color: green;"></i>
                                                            @else
                                                                <i class="fa fa-circle-o fa-2x" style="color: #9BA2AB;"></i>
                                                            @endif
                                                        </td>
                                                        <td class="text-center">
                                                            @php
                                                                $check = false;
                                                                $check = DateTime::createFromFormat('Y-m-d', $expense->payday);
                                                            @endphp
                                                            @if($check)
                                                                {{date("d/m/Y", strtotime($expense['payday']))}}
                                                            @else
                                                                -
                                                            @endif

                                                        </td>
                                                        <td class="text-center">
                                                            @if(!empty($expense->billing_file))
                                                                <a href="?download=billing_file&expense={{$expense->id}}"
                                                                   class="btn btn-warning"><i
                                                                            class="icmn icmn-download4"></i></a>
                                                            @endif
                                                        </td>
                                                        <td class="text-center">
                                                            @if(!empty($expense->payment_file))
                                                                <a href="?download=payment_file&expense={{$expense->id}}"
                                                                   class="btn btn-warning"><i
                                                                            class="icmn icmn-download4"></i></a>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <a href="{{route('gerencial.contrato.expenses.edit', ['contract'=> $contract->id, 'expense' => $expense->id])}}"
                                                               class="btn btn-default"><i class="fa fa-edit"></i></a>
                                                            <button class="btn btn-danger"
                                                                    onclick="remove({{$expense->id}})"><i
                                                                        class="fa fa-times-circle"></i></button>
                                                        </td>
                                                    </tr>
                                                    @php
                                                        $i++;
                                                    @endphp

                                                @endforeach
                                            @endif
                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Dashboard -->

        </div>


        <!-- Page Scripts -->
        <script>
            $(function () {

                $("[data-toggle=popover]").popover();
                $("[data-toggle=popover-hover]").popover({
                    trigger: 'hover'
                });

                $("[data-toggle=tooltip]").tooltip();

                $('#table1').DataTable({
                    responsive: false,
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
                    "order": [[2, 'desc']],
                    "iDisplayLength": 50,
                    paging: true
                });

                ///////////////////////////////////////////////////////////
                // COUNTERS
                $('.counter-init').countTo({
                    speed: 500
                });
            });

            function remove(id) {
                response = confirm('Você quer realmente excluir a despesa de ID#' + id + '?');
                if (response) {
                    window.location.href = '/gerencial/contrato/{{$contract->id}}/expenses/' + id + '/remove';
                } else {
                    return false;
                }

            }
        </script>

        <!-- End Page Scripts -->
    </section>

@endsection