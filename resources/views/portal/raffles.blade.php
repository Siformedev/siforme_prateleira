@extends('portal.inc.layout')

@section('content')

    @php
    $dateRaffle = \Carbon\Carbon::createFromFormat("Y-m-d", $raffle->draw_date)->diff(\Carbon\Carbon::createFromFormat('Y-m-d', '2019-12-29'));
    if($dateRaffle->invert == 0 && $dateRaffle->days > 0){
        $raffleStatus = 0;
    }else{
        $raffleStatus = 1;
    }
    @endphp

    <section class="page-content">
        <div class="page-content-inner">

            <!--  -->
            <section class="panel">
                <div class="panel-heading">
                    <button class="btn btn-default float-right" data-toggle="modal" data-target="#myModal_raffle">Regras</button>
                    <h3>Rifa Coletiva Online {{$raffle->name}} - Prêmio: {{$raffle->premium}} </h3>
                    <h6>O sorteio será realizado através da Loteria Federal no dia: {{date('d/m/Y', strtotime($raffle->draw_date))}}</h6>
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
                                <p>{!!  $raffle->rules !!}</p>
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
                                    <th>Número</th>
                                    <th>Nome do Comprador</th>
                                    <th>Telefone</th>
                                    <th>E-mail</th>
                                    <th>Valor</th>
                                    <th>Data da Compra</th>
                                    <th>Ação</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($forming_raffle_numbers as $raffle_number)
                                    @php

                                        if($raffle_number->buyer_name == '' or empty($raffle_number->buyer_name)){
                                            if($raffleStatus){
                                                $action = '<a href="'.route('portal.raffle.number.update', ['number' => $raffle_number->id]).'" class="btn btn-success display-block">Cadastrar Comprador</a>';
                                                $valor = number_format($raffle->price, 2, ",", ".");
                                                $stylePrice = 'color: #D9DCDC';
                                            }else{
                                                $action = '<a class="btn btn-default display-block">Sorteio já realizado</a>';
                                                $valor = '';
                                                $stylePrice = '';
                                            }
                                        }else{
                                            $action = '<a href="'.route('portal.raffle.number.view', ['number' => $raffle_number->id]).'" class="btn btn-info display-block">Imprimir</a>';
                                            $valor = number_format($raffle->price, 2, ",", ".");
                                            $stylePrice = '';
                                        }


                                    @endphp
                                    <tr>
                                        <td><span class="font-size-16 font-weight-bold">{{ str_pad($raffle_number->number, 5, '0', STR_PAD_LEFT) }}</span></td>
                                        <td>{{$raffle_number->buyer_name}}</td>
                                        <td>{{$raffle_number->buyer_phone}}</td>
                                        <td>{{$raffle_number->buyer_email}}</td>
                                        <td style="{{$stylePrice}}">{{$valor}}</td>
                                        <td>@if(!empty($raffle_number->purchase_date)){{date('d/m/Y', strtotime($raffle_number->purchase_date))}}@endif</td>
                                        <td>
                                            {!! $action !!}
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