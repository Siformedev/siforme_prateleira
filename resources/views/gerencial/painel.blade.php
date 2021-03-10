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
                                    <h5 class="text-uppercase">Valor arrecadado</h5>
                                    <i class="counter-icon icmn-cash3"></i>
                                    <span class="counter-count">

                                R$<span class="counter-init" data-from="25" data-to="942">942</span> Mil
                            </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-sm-6 col-xs-12">
                        <div class="widget widget-seven background-default">
                            <div class="widget-body">
                                <div href="javascript: void(0);" class="widget-body-inner">
                                    <h5 class="text-uppercase">Adesões Hoje</h5>
                                    <i class="counter-icon icmn-cart-add2"></i>
                                    <span class="counter-count">
                                <span class="counter-init" data-from="0" data-to="19">19</span>
                            </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-sm-6 col-xs-12">
                        <div class="widget widget-seven background-success">
                            <div class="widget-body">
                                <div href="javascript: void(0);" class="widget-body-inner">
                                    <h5 class="text-uppercase">Formandos Adimplentes</h5>
                                    <i class="counter-icon icmn-users"></i>
                                    <span class="counter-count">
                                <i class="icmn-arrow-up5"></i>
                                <span class="counter-init" data-from="0" data-to="167">167</span>
                            </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-sm-6 col-xs-12">
                        <div class="widget widget-seven background-warning">
                            <div class="widget-body">
                                <div href="javascript: void(0);" class="widget-body-inner">
                                    <h5 class="text-uppercase">Formandos Inadimplentes</h5>
                                    <i class="counter-icon icmn-users"></i>
                                    <span class="counter-count">
                                <i class="icmn-arrow-up5"></i>
                                <span class="counter-init" data-from="0" data-to="12">12</span>
                            </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-lg-8">
                        <h4>Gafico de Adesões</h4>
                        <br />
                        <div class="margin-bottom-50">
                            <div class="chart-overlapping-bar height-300 chartist"></div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <h4>Meta</h4>
                        <br />
                        <div class="margin-bottom-50">
                            <div class="chart-donut-chart"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">

                        <br>
                        <div class="margin-bottom-50">
                            <div class="nav-tabs-horizontal">
                                <ul class="nav nav-tabs" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" href="javascript: void(0);" data-toggle="tab" data-target="#alvo1" role="tab" aria-expanded="true">Últimas Adesões (3 dias)</a>
                                    </li>
                                </ul>
                                <div class="tab-content padding-vertical-20">

                                    <div class="tab-pane active" id="alvo1" role="tabpanel" aria-expanded="true">
                                        <table class="table table-hover dataTable dtr-inline table-respnsive" id="table1">
                                            <thead>
                                            <tr>
                                                <th>Nome</th>
                                                <th>Curso</th>
                                                <th>Periodo</th>
                                                <th>% Pago</th>
                                                <th>Status</th>
                                                <th>Ação</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @for($i=1; $i<=1; $i++)
                                                <tr>
                                                    <td><span class="font-size-16 font-weight-bold">Nome Completo do Formando</span></td>
                                                    <td>Adiministraçào</td>
                                                    <td>Noturno</td>
                                                    <td>
                                                        <progress class="progress progress-success" value="86" max="100">25%</progress>
                                                    </td>
                                                    <td><span class="label label-success">Adimplente</span> </td>
                                                    <td>
                                                        <a href="" class="btn btn-success">Visualizar</a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><span class="font-size-16 font-weight-bold">Fabio Luiz Henrique</span></td>
                                                    <td>Direito</td>
                                                    <td>Diurno</td>
                                                    <td>
                                                        <progress class="progress progress-warning" value="53" max="100">25%</progress>
                                                    </td>
                                                    <td><span class="label label-success">Adimplente</span> </td>
                                                    <td>
                                                        <a href="{{route('comissao.formandos.show')}}" class="btn btn-success">Visualizar</a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><span class="font-size-16 font-weight-bold">Fabiola Machado Dos Santos </span></td>
                                                    <td>Adiministraçào</td>
                                                    <td>Diurno</td>
                                                    <td>
                                                        <progress class="progress progress-danger" value="10" max="100">25%</progress>
                                                    </td>
                                                    <td><span class="label label-success">Adimplente</span> </td>
                                                    <td>
                                                        <a href="" class="btn btn-success">Visualizar</a>
                                                    </td>
                                                </tr>
                                            @endfor
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
                    speed: 1500
                });


                // OVERLAPPING BAR
                var overlappingData = {
                        labels: ["JAN", "FEV", "MAR", "ABR", "MAI", "JUN", "JUL", "AGO", "SET", "OUT", "NOV", "DEZ"],
                        series: [
                            [15, 6, 3, 7, 5, 10, 3, 4, 8, 1, 6, 8],
                            [3, 2, 9, 5, 4, 6, 4, 6, 7, 8, 7, 4]
                        ]
                    },
                    overlappingOptions = {
                        seriesBarDistance: 10,
                        plugins: [
                            Chartist.plugins.tooltip()
                        ]
                    },
                    overlappingResponsiveOptions = [
                        ["", {
                            seriesBarDistance: 5,
                            axisX: {
                                labelInterpolationFnc: function(value) {
                                    return value[0]+value[1]+value[2];
                                }
                            }
                        }]
                    ];

                new Chartist.Bar(".chart-overlapping-bar", overlappingData, overlappingOptions, overlappingResponsiveOptions);

            });
        </script>

        <script>
            $(function () {

                var colors = {
                    _primary: '#01a8fe',
                    _default: '#acb7bf',
                    _success: '#46be8a',
                    _danger: '#fb434a'
                };




                c3.generate({
                    bindto: '.chart-donut-chart',
                    data: {
                        columns: [
                            ['Falta', 30],
                            ['Alcançado', 120]
                        ],
                        type : 'donut'
                    },
                    color: {
                        pattern: [colors._danger, colors._success]
                    },
                    donut: {
                        title: "META"
                    }
                });

            });
        </script>
        <!-- End Page Scripts -->
    </section>

@endsection