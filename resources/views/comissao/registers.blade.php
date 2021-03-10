@extends('comissao.inc.layout')

@section('content')

    <section class="page-content">
        <div class="page-content-inner">

            <!--  -->
            <section class="panel">
                <div class="panel-heading">
                    <h3>Listagem de Registros</h3>
                    <hr>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-hover nowrap dataTable dtr-inline" id="table1">
                                <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>Curso</th>
                                    <th>CPF</th>
                                    <th>Telefone</th>
                                    <th>Intenção de Adesão</th>
                                    <th>Presença</th>
                                    <th>Data cadastro</th>

                                </tr>
                                </thead>
                                <tbody>
                                @foreach($registers as $register)
                                    <?php
                                    ?>
                                    <tr>
                                        <td>
                                            @php
                                                if(in_array($register->cpf, $cpfs)){
                                                    $img_capelo = asset('img/comissao/icons/capelo_on.png');
                                                }else{$img_capelo = asset('img/comissao/icons/capelo_off.png');}
                                            @endphp
                                            <img src="{{ $img_capelo }}" style="width: 30px"> &nbsp
                                            <span class="font-size-16 font-weight-bold">{{title_case($register->name)}}</span>
                                        </td>
                                        <td>{{\App\Course::find($register->course)['name']}}</td>
                                        <td>{{$register->cpf}}</td>
                                        <td>{{$register->cellphone}}</td>
                                        <td>
                                            @php switch ($register->intention){
                                                    case 1: echo 'Tenho interesse'; break;
                                                    case 2: echo 'Talvez'; break;
                                                    case 3: echo 'Não tenho interesse'; break;
                                                }
                                            @endphp
                                        </td>
                                        <td class="text-center">
                                            @php if($register->checked == 0){$img = asset('img/comissao/icons/checkunmark.png'); }else{ $img = asset('img/comissao/icons/checkmark.png'); } @endphp
                                            <img id="check_{{$register->id}}" onClick="check({{$register->id}})" src="{{ $img }}" style="width: 30px; cursor: pointer;">
                                        </td>
                                        <td>{{date("d/m/Y H:i", strtotime($register->created_at))}}</td>


                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
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
                                        <td id="qt_check_on">{{$registers->where('checked', 1)->count()}}</td>
                                        <td id="qt_check_off">{{$registers->where('checked', 0)->count()}}</td>
                                    </tr>
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


    <script type="text/javascript">
        function check(id) {
            $('#check_'+id).attr('src', '{{asset('img/comissao/icons/check_loading.gif')}}');

            $.get("{{env('APP_URL')}}/api/app/register/"+id+"/checked", function(data, status){
                var check_on = $("#qt_check_on");
                var check_off = $("#qt_check_off");

                if(data.checked == 1){

                    var tempQt = parseInt(check_on.text());
                    tempQt+=1;
                    check_on.text(tempQt);

                    var tempQt_ = parseInt(check_off.text());
                    tempQt_-=1;
                    check_off.text(tempQt_);

                    $('#check_'+id).attr('src', '{{asset('img/comissao/icons/checkmark.png')}}');
                }else if(data.checked == 0){

                    var tempQt = parseInt(check_on.text());
                    tempQt-=1;
                    check_on.text(tempQt);

                    var tempQt_ = parseInt(check_off.text());
                    tempQt_+=1;
                    check_off.text(tempQt_);

                    $('#check_'+id).attr('src', '{{asset('img/comissao/icons/checkunmark.png')}}');
                }
            });
        }
    </script>

@endsection