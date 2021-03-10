@extends('gerencial.inc.layout')

@section('content')
    <section class="page-content">
        <div class="page-content-inner">
            <section class="panel">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-2"><img class="img-responsive img-thumbnail img-circle img-prod" style="width: 150px; height: 150px;" src="{{asset($forming->img)}}"></div>
                        <div class="col-md-5">
                            <h3>ID#{{$forming->id}}</h3>
                            
                            <h3>{{$forming->nome}} {{$forming->sobrenome}}</h3>
                            <h1><span class="label label-warning">{{$forming->contract->name}}</span> <br> </h1>
                            <h1><span class="label label-success">{{\App\Course::find($forming->curso_id)['name']}}</span> <br> <span class="label label-info">{{\App\ConfigApp::Periodos()[$forming->periodo_id]}}</span></h1>
                            <p><span class="font-size-20"><i class="icmn icmn-arrow-right6"></i> CPF: {{$forming->cpf}}</span></p>
                            <p><span class="font-size-20"><i class="icmn icmn-arrow-right6"></i> Telefone Residencial: {{$forming->telefone_residencial}}</span></p>
                            <p><span class="font-size-20"><i class="icmn icmn-arrow-right6"></i> Telefone Celular: {{$forming->telefone_celular}}</span></p>
                            <p><span class="font-size-20"><i class="icmn icmn-mail4"></i> {{$forming->email}}</span></p>
                            <p><span class="font-size-20"><i class="icmn icmn-calendar"></i> {{date("d/m/Y", strtotime($forming->dt_adesao))}}</span></p>
                        </div>
                        <div class="col-md-4">
                            <span>

                            </span>
                        </div>
                        <div class="col-md-1"><a class="btn btn-default" href="{{ route('gerencial.formandos') }}">Voltar</a> </div>
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
                                                                    <th>Parcelas</th>
                                                                    <th>Quant.</th>
                                                                    <th colspan="2" style="width: 80px;">% Pago</th>
                                                                    <th>Status</th>
                                                                    <!--<th>#</th>-->
                                                                </tr>
                                                                </thead>
                                                                <tbody>

                                                                @foreach($prods as $product)


                                                                    <tr>
                                                                        <td><span class="label label-info">#{{$product->id}}</span></td>
                                                                        <td>
                                                                            <span class="font-size-16 font-weight-bold">
                                                                                {{$product->name}}
                                                                                @if($product->withdrawn > 0)
                                                                                    <br><span class="label label-warning font-size-18" style="padding: 10px; margin-top: 10px;">Retirado {{ $product->withdrawn }} convite (s)</span>
                                                                                @endif
                                                                            </span>
                                                                        </td>
                                                                        <td>{{date("d/m/Y", strtotime($product->created_at))}}</td>
                                                                        <td>R$ {{number_format(($product->value - ($product->value * ($product->discounts / 100))),2,',', '.')}}</td>
                                                                        <td>{{$product->parcels}}</td>
                                                                        <td>{{$product->amount}}</td>
                                                                        <td style="width: 20px;">
                                                                            {{$products['perc'][$product->id]}}%
                                                                        </td>
                                                                        <td style="width: 60px;">
                                                                            <progress class="progress progress-info" value="{{$products['perc'][$product->id]}}" max="100"></progress>
                                                                        </td>
                                                                        <td><span class="label label-{{$formingLabel[$product->id]}}">{{$products[$product->id]}}</span> </td>
                                                                        <td>
                                                                            <a href="{{route('gerencial.formando.show.item', ['prod' => $product->id])}}" class="btn btn-success"><i class="icmn icmn-zoom-in"></i></a>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </section>

                                        </div>

                                        <div class="tab-pane" id="alvo2" role="tabpanel" aria-expanded="true">
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
                                                                    <th>Parcelas</th>
                                                                    <th>Quant.</th>
                                                                    <th>Status</th>
                                                                    <!--<th>#</th>-->
                                                                </tr>
                                                                </thead>
                                                                <tbody>

                                                                @foreach($prods_cancel as $product_cancel)


                                                                    <tr>
                                                                        <td><span class="label label-info">#{{$product_cancel->id}}</span></td>
                                                                        <td><span class="font-size-16 font-weight-bold">{{$product_cancel->name}}</span></td>
                                                                        <td>{{date("d/m/Y", strtotime($product->created_at))}}</td>
                                                                        <td>R$ {{number_format(($product_cancel->value - ($product_cancel->value * ($product_cancel->discounts / 100))),2,',', '.')}}</td>
                                                                        <td>{{$product_cancel->parcels}}</td>
                                                                        <td>{{$product_cancel->amount}}</td>
                                                                        <td><span class="label label-danger">CANCELADO</span></td>




                                                                    </tr>
                                                                @endforeach
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
