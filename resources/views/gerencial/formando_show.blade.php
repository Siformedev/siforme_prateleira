@extends('comissao.inc.layout')

@section('content')
    <section class="page-content">
        <div class="page-content-inner">
            <section class="panel">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-2"><img class="img-responsive img-thumbnail img-circle img-prod" style="width: 150px; height: 150px;" src="http://mhalabs.org/wp-content/uploads/upme/1451456913_brodie.jpg"></div>
                        <div class="col-md-5">
                            <h3>Fabio Luiz Henrique</h3>
                            <h1><span class="label label-success">Direito</span> | <span class="label label-info">Diurno</span></h1>
                            <p><span class="font-size-20"><i class="icmn icmn-mail4"></i> fabioluiz@gmail.com</span></p>
                        </div>
                        <div class="col-md-4">
                            <span>

                            </span>
                        </div>
                        <div class="col-md-1"><a class="btn btn-default" href="{{route('comissao.formandos')}}">Voltar</a> </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-body">

                    <div class="row">
                        <h3>Produtos e Serviços Adquiridos</h3>
                        <hr>
                        <div class="col-md-12">

                            <br>
                            <div class="margin-bottom-50">
                                <div class="nav-tabs-horizontal">
                                    <ul class="nav nav-tabs" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" href="javascript: void(0);" data-toggle="tab" data-target="#alvo1" role="tab" aria-expanded="true">Compras Realizadas</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="javascript: void(0);" data-toggle="tab" data-target="#alvo2" role="tab" aria-expanded="true">Cancelamentos</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content padding-vertical-20">

                                        <div class="tab-pane active" id="alvo1" role="tabpanel" aria-expanded="true">
                                            <section class="panel">
                                                <div class="panel-body">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <table class="table table-hover dataTable table-responsive" id="table1">
                                                                <thead>
                                                                <tr>
                                                                    <th>COD.</th>
                                                                    <th>Descrição</th>
                                                                    <th>Data</th>
                                                                    <th>Valor</th>
                                                                    <th>Quant.</th>
                                                                    <th>% Pago</th>
                                                                    <th>Status</th>
                                                                    <th>#</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                @for($i=1; $i<=1; $i++)
                                                                    <tr>
                                                                        <td><span class="label label-info">#0004745</span></td>
                                                                        <td><span class="font-size-16 font-weight-bold">Fomartura completa c/ 10 convites</span></td>
                                                                        <td>01/07/2017</td>
                                                                        <td>R$ 3.567,23</td>
                                                                        <td>1</td>
                                                                        <td>
                                                                            <progress class="progress progress-warning" value="34" max="100">34%</progress>
                                                                        </td>
                                                                        <td><span class="label label-success">Adimplente</span> </td>
                                                                        <td>
                                                                            <a href="{{route('comissao.formandos.show.item')}}" class="btn btn-success"><i class="icmn icmn-zoom-in"></i></a>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><span class="label label-info">#0004746</span></td>
                                                                        <td><span class="font-size-16 font-weight-bold">Álbum Fotografico Modelo 2</span></td>
                                                                        <td>01/07/2017</td>
                                                                        <td>R$ 2.500,00</td>
                                                                        <td>1</td>
                                                                        <td>
                                                                            <progress class="progress progress-success" value="56" max="100">56%</progress>
                                                                        </td>
                                                                        <td><span class="label label-success">Adimplente</span> </td>
                                                                        <td>
                                                                            <a href="" class="btn btn-success"><i class="icmn icmn-zoom-in"></i></a>
                                                                        </td>
                                                                    </tr><tr>
                                                                        <td><span class="label label-info">#0004747</span></td>
                                                                        <td><span class="font-size-16 font-weight-bold">Convite Extra de Baile</span></td>
                                                                        <td>01/07/2017</td>
                                                                        <td>R$ 1.050,00</td>
                                                                        <td>3</td>
                                                                        <td>
                                                                            <progress class="progress progress-success" value="85" max="100">85%</progress>
                                                                        </td>
                                                                        <td><span class="label label-success">Adimplente</span> </td>
                                                                        <td>
                                                                            <a href="" class="btn btn-success"><i class="icmn icmn-zoom-in"></i></a>
                                                                        </td>
                                                                    </tr>
                                                                @endfor
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </section>

                                        </div>

                                        <div class="tab-pane" id="alvo2" role="tabpanel" aria-expanded="true">
                                            <section class="panel">
                                                <div class="panel-heading">
                                                    <h3><a href=""></a></h3>
                                                </div>
                                                <div class="panel-body">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <table class="table table-hover dataTable dtr-inline table-responsive" id="table1">
                                                                <thead>
                                                                <tr>
                                                                    <th>COD.</th>
                                                                    <th>Descrição</th>
                                                                    <th>Data</th>
                                                                    <th>Valor</th>
                                                                    <th>Quant.</th>
                                                                    <th>Data Cancelamento</th>
                                                                    <th>Status</th>
                                                                    <th>#</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                @for($i=1; $i<=1; $i++)
                                                                    <tr>
                                                                        <td><span class="label label-info">#0002746</span></td>
                                                                        <td><span class="font-size-16 font-weight-bold">Combo Mesa Extra</span></td>
                                                                        <td>09/07/2017</td>
                                                                        <td>R$ 4.020,00</td>
                                                                        <td>1</td>
                                                                        <td>12/07/2017</td>
                                                                        <td><span class="label label-danger">Cancelado</span> </td>
                                                                        <td class="font-size-20 color-danger">
                                                                            <i class="icmn icmn-cancel-circle"></i>
                                                                        </td>
                                                                    </tr>
                                                                @endfor
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </section>

                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
                <div class="panel-footer">

                </div>
            </section>
        </div>

    </section>

    <script>
        $(function () {
            $('.selectsActives').change(function () {
                var prodId = $('#prodId').val();
                var qt = $('#selectQuantidade').val();
                var dia = $('#diaPagamento').val();
                window.location = '/portal/comprasextras/'+prodId+'/'+qt+'/'+dia;
            });
        });
    </script>

@endsection