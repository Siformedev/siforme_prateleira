@extends('comissao.inc.layout')

@section('content')

    <section class="page-content">
        <div class="page-content-inner">

            <!-- Dashboard -->
            <div class="dashboard-container">
                <div class="row">
                    <div class="col-xl-3 col-lg-6 col-sm-6 col-xs-12">
                        <div class="widget widget-seven background-info">
                            <div class="widget-body">
                                <div href="javascript: void(0);" class="widget-body-inner">
                                    <h5 class="text-uppercase">VENDAS</h5>
                                    <i class="counter-icon icmn-users"></i>
                                    <span class="counter-count">

                                <span class="counter-init" data-from="0" data-to="{{$totals['count']}}">{{$totals['count']}}}</span>
                            </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-sm-6 col-xs-12">
                        <div class="widget widget-seven background-warning">
                            <div class="widget-body">
                                <div href="javascript: void(0);" class="widget-body-inner">
                                    <h5 class="text-uppercase">Total Vendido</h5>
                                    <i class="counter-icon icmn-users"></i>
                                    <span class="counter-count">

                                    {{number_format($totals['sold'],2,",",".")}}
                            </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-sm-6 col-xs-12">
                        <div class="widget widget-seven background-default">
                            <div class="widget-body">
                                <div href="javascript: void(0);" class="widget-body-inner">
                                    <h5 class="text-uppercase">A Receber</h5>
                                    <i class="counter-icon icmn-users"></i>
                                    <span class="counter-count">

                                {{number_format($totals['to_receive'],2,",",".")}}
                            </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-sm-6 col-xs-12">
                        <div class="widget widget-seven background-success">
                            <div class="widget-body">
                                <div href="javascript: void(0);" class="widget-body-inner">
                                    <h5 class="text-uppercase">Saldo em conta</h5>
                                    <i class="counter-icon icmn-users"></i>
                                    <span class="counter-count">
                                        {{number_format($totals['receiving'],2,",",".")}}
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
                        <a href="{{route('comissao.lojinha.vendastotal')}}" class="btn btn-info float-right">TODAS VENDAS</a>
                        <div class="margin-bottom-50">
                            <div class="nav-tabs-horizontal">
                                <ul class="nav nav-tabs" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" href="javascript: void(0);" data-toggle="tab" data-target="#alvo1" role="tab" aria-expanded="true">Últimas vendas</a>
                                    </li>
                                </ul>
                                <div class="tab-content padding-vertical-20">

                                    <div class="tab-pane active" id="alvo1" role="tabpanel" aria-expanded="true">
                                        <table class="table table-hover dataTable dtr-inline table-responsive" id="table1">
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
                                                        if($i > 20){ break; }
                                                        $valor_liquido = $venda['total']-$venda['rate'];
                                                @endphp
                                                <tr>
                                                    <td>#{{$venda['id']}}</td>
                                                    <td>{{$venda['forming_name']}}</td>
                                                    <td>{{$venda['quants']}}</td>
                                                    <td>{{number_format($venda['total'], 2, ",", ".")}}</td>
                                                    <td>{{number_format($venda['rate'], 2, ",", ".")}}</td>
                                                    <td>{{date("d/m/Y H:i", strtotime($venda['created_at']))}}</td>
                                                    <td>{{date("d/m/Y", strtotime($venda['receiving_date']))}}</td>
                                                    <td>{{number_format($valor_liquido, 2, ",", ".")}}</td>
                                                    <td>{{\App\ConfigApp::GiftRequetsStatus()[$venda['status']]}}</td>
                                                    <td>@if($venda['receiving']) <label class="label label-success">S</label> @else <label class="label label-danger">N</label>  @endif</td>
                                                    <td><a href="{{route('comissao.lojinha.venda.detalhes', ['id' => $venda['id']])}}" class="btn btn-warning"><i class="icmn icmn-search"></i> </a> </td>
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
                        </div>
                    </div>
                </div>

            </div>
            <!-- End Dashboard -->

        </div>


        <!-- Page Scripts -->
        <script>
            $(function() {

                ///////////////////////////////////////////////////////////
                // COUNTERS
                $('.counter-init').countTo({
                    speed: 500
                });
            });
        </script>

        <!-- End Page Scripts -->
    </section>

@endsection