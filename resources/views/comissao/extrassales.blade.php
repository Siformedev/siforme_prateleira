@extends('comissao.inc.layout')

@section('content')

    <section class="page-content">
        <div class="page-content-inner">

            <!--  -->
            <section class="panel">
                <div class="panel-heading">
                    <h3>Listagem de Vendas Extras</h3>
                    <hr>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-2">Filtro:</div>
                            <div class="col-md-10">
                                <select name="group" class="form-control" id="selectOn">
                                    <option value="all" @if(empty($name) || $name === 'all') selected @endif()>Todos</option>
                                    @foreach($productsGroup as $pg)
                                        <option value="{{$pg}}" @if($pg == $name) selected @endif()>
                                            {{$pg}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <br>
                        <hr>
                        <div class="col-md-12">
                            <table class="table table-hover nowrap dataTable dtr-inline table-responsive" id="table1">
                                <thead>
                                <tr>
                                    <th>Cód Pedido</th>
                                    <th >Descrição</th>
                                    <th>Formando</th>
                                    <th>Valor</th>
                                    <th >Quantidade</th>
                                    <th>Subtotal</th>
                                    <th>Ação</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $qts = 0;
                                $total = 0;
                                ?>
                                @foreach($vendas as $venda)
                                    <?php
                                    $qts += $venda->amount;
                                    $total += $venda->valorFinal();
                                    ?>
                                    <tr>
                                        <td><span class="font-size-16 font-weight-bold">{{$venda->id}}</span></td>
                                        <td>{{$venda->name}}</td>
                                        <td>{{$venda->forming->nome}} {{$venda->forming->sobrenome}}</td>
                                        <td class="text-center">{{number_format($venda->valorComDesconto(),2,",",".")}}</td>
                                        <td class="text-center">{{$venda->amount}}</td>
                                        <td class="text-center">{{number_format(($venda->valorFinal()),2,",",".")}}</td>
                                        <td>
                                            <a href="{{route('comissao.formandos.show', ['forming' => $venda->forming->id])}}" class="btn btn-success"><img style="width: 25px" src="https://i.pinimg.com/originals/ce/a2/72/cea2728d2248df5d09f6104db64ea2be.png" title="Ver Formando"></a>
                                            <a href="{{route('comissao.formandos.show.item', ['prod' => $venda->id])}}" class="btn btn-success"><img style="width: 25px" src="https://pngimage.net/wp-content/uploads/2018/06/pedidos-icon-png-2.png" title="Ver Pedido"></a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="2" class="text-right"></td>
                                        <td class="text-center"><b>TOTAL VENDIDOS</b></td>
                                        <td  class="text-center"></td>
                                        <td  class="text-center"><b>{{$qts}}</b></td>
                                        <td  class="text-right"><b>{{number_format($total, 2, ",", ".")}}</b></td>
                                        <td  class="text-right"></td>
                                    </tr>
                                </tfoot>
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
                    "iDisplayLength": 25,
                    paging: true
                });

                $('#selectOn').change(function (e) {
                    var name = $(this).val();
                    window.location.href = "?name="+name;
                })
            });
        </script>
        <!-- End Page Scripts -->
    </section>

@endsection
