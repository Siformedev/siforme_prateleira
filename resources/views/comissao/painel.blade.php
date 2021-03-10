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
                                    <h5 class="text-uppercase">TOTAL DE FORMANDOS</h5>
                                    <i class="counter-icon icmn-users"></i>
                                    <span class="counter-count">

                                <span class="counter-init" data-from="0" data-to="{{$formingArray['total']}}">{{$formingArray['total']}}}</span>
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

                                <span class="counter-init" data-from="0" data-to="{{$formingArray['adimplentes']}}">{{$formingArray['adimplentes']}}</span>
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

                                <span class="counter-init" data-from="0" data-to="{{$formingArray['inadimplentes']}}">{{$formingArray['inadimplentes']}}</span>
                            </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-sm-6 col-xs-12">
                        <div class="widget widget-seven background-default">
                            <div class="widget-body">
                                <div href="javascript: void(0);" class="widget-body-inner">
                                    <h5 class="text-uppercase">Formandos Pendentes</h5>
                                    <i class="counter-icon icmn-users"></i>
                                    <span class="counter-count">
                                <span class="counter-init" data-from="0" data-to="{{$formingArray['pendentes']}}">{{$formingArray['pendentes']}}</span>
                            </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-lg-12">
                        <h4>Gráfico de Adesões</h4>
                        <br />
                        <div class="margin-bottom-50">
                            <div class="chart-overlapping-bar height-300 chartist"></div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <h4>Gráfico por cursos</h4>
                        <br />
                        <div class="margin-bottom-50">
                            <div class="chart-horizontal-bar height-300 chartist"></div>
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
                                        <a class="nav-link active" href="javascript: void(0);" data-toggle="tab" data-target="#alvo1" role="tab" aria-expanded="true">Adesões de hoje</a>
                                    </li>
                                </ul>
                                <div class="tab-content padding-vertical-20">

                                    <div class="tab-pane active" id="alvo1" role="tabpanel" aria-expanded="true">
                                        <table class="table table-hover dataTable dtr-inline table-respnsive" id="table1">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Nome</th>
                                                <th>Hora da adesão</th>
                                                <th>Curso</th>
                                                <th>Periodo</th>
                                                <th>#</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @php
                                                $i = 1;
                                            @endphp
                                            @foreach($formingNowDay as $formingND)
                                                <tr>
                                                    <td>{{$i}}</td>
                                                    <td><span class="font-size-16 font-weight-bold">{{$formingND->nome}} {{$formingND->sobrenome}}</span></td>
                                                    <td>{{date("H:i", strtotime($formingND->created_at))}}</td>
                                                    <td>{{\App\Course::find($formingND->curso_id)['name']}}</td>
                                                    <td>{{\App\ConfigApp::Periodos()[$formingND->periodo_id]}}</td>
                                                    <td> <a href="{{route('comissao.formandos.show', ['$forming' => $formingND->id])}}" class="btn btn-success">Visualizar</a></td>

                                                    </td>
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


                // OVERLAPPING BAR
                var overlappingData = {
                        labels: [{!! $dataAdesaoGrafico['key'] !!}],
                        series: [[{!! $dataAdesaoGrafico['data'] !!}]]
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
                                    return value;
                                }
                            }
                        }]
                    ];

                new Chartist.Bar(".chart-overlapping-bar", overlappingData, overlappingOptions, overlappingResponsiveOptions);

                // HORIZONTAL BAR
                new Chartist.Bar(".chart-horizontal-bar", {
                    labels: {!! $graf_courses_title !!},
                    series: [{!! $graf_courses_quant !!}]
                }, {
                    chartPadding: 0,

                    seriesBarDistance: 10,
                    reverseData: !0,
                    horizontalBars: !0,
                    axisY: {
                        offset: 80
                    },
                    plugins: [
                        Chartist.plugins.tooltip()
                    ]
                });

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
                            ['Inalcançado', {{$meta['inalcancado']}}],
                            ['Alcançado', {{$meta['alcancado']}}]
                        ],
                        type : 'donut'
                    },
                    color: {
                        pattern: [colors._danger, colors._success]
                    },
                    donut: {
                        title: "META: {{$contract->goal}} Formandos"
                    }
                });

            });
        </script>
        <!-- End Page Scripts -->
    </section>

@endsection