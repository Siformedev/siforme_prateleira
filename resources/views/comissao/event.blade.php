@extends('comissao.inc.layout')

@section('content')

    <section class="page-content">
        <div class="page-content-inner">

            <!--  -->
            <section class="panel">
                <div class="panel-heading">
                    <h3>Listagem de Comparecimento Evento: {{$event->name}}</h3>
                    <hr>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-hover nowrap dataTable dtr-inline table-responsive" id="table1">
                                <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>RG</th>
                                    <th>Curso</th>
                                    <th>Compareceu</th>
                                    <th>Data e Hora do Checkin</th>
                                    <th>Checkin</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php
                                    $total_checkeds = 0;
                                @endphp
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
                                        <td>{{$forming->rg}}</td>
                                        <td class="text-center"  id="fstatus_{{$forming->id}}">
                                            @php
                                                $checkin = \App\EventCheckin::where('event_id', $event->id)->where('contract_id', $contract->id)->where('forming_id', $forming->id)->first();
                                                $status = "N";
                                                $checkin_datetime_A = '-';
                                                if(isset($checkin->created_at)){
                                                    $status = "S";
                                                    $total_checkeds++;
                                                    $checkin_datetime = $checkin->created_at;
                                                    $checkin_datetime_A = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $checkin_datetime)->format('d/m/Y H:i');

                                                }
                                            @endphp
                                            {{$status}}
                                        </td>
                                        <td class="text-center" id="fdate_{{$forming->id}}">{{$checkin_datetime_A}}</td>

                                        </td>

                                        <td class="text-center">
                                            <div id="fid_{{$forming->id}}">
                                            @if($status == "S")
                                                <i class="fa fa-check color-success"></i>
                                            @else
                                                <button onClick="check( {{$event->id}}, {{$forming->id}} )" class="btn btn-info btn-sm">Checkin</button>
                                            @endif
                                            </div>
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

        <div class="row">
            <div class="col-md-12">
                <table class="table table-hover nowrap dataTable dtr-inline table-responsive" id="table1">
                    <thead>
                    <tr>
                        <th>Quant Checados</th>
                        <th>Quant Não Checados</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td id="qt_check_on">{{$total_checkeds}}</td>
                        <td>{{$formings->count()}}</td>
                    </tr>
                    </tbody>
                </table>
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
                    "iDisplayLength": 25,
                    paging: true
                });
            });
        </script>
        <!-- End Page Scripts -->
    </section>

    <script type="text/javascript">
        function check(event, forming) {
            $('#fid_'+forming).html('<img src="{{asset('img/comissao/icons/check_loading.gif')}}" style="height: 15px;">');

            $.get("{{env('APP_URL')}}/api/app/event/checkin/"+event+"/"+forming+"/", function(data, status){

                if(data.checked == 1){

                    $('#fid_'+forming).html(' <i class="fa fa-check color-success"></i>');
                    $('#fstatus_'+forming).html("S");
                    $('#fdate_'+forming).html(data.datetime);
                    $('#qt_check_on').html(data.total_checkeds);

                    $.notify("Checkin do "+data.name+" realizado com sucesso!", {
                        animate: {
                            enter: 'animated zoomInDown',
                            exit: 'animated zoomOutUp'
                        },
                        type: "success",
                        delay: 2000,
                        timer: 100,
                    });
                }else{

                    $.notify("Erro, tente novamente!", {
                        animate: {
                            enter: 'animated zoomInDown',
                            exit: 'animated zoomOutUp'
                        },
                        type: "danger",
                        delay: 2000,
                        timer: 100,
                    });
                    $('#fid_'+forming).html('<button href="#" onClick="check( {{$event->id}}, {{$forming->id}} )" class="btn btn-info btn-sm">Checkin</button> ');

                }
            });
        }
    </script>

@endsection
