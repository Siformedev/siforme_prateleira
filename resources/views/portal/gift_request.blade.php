@extends('portal.inc.layout')

@section('content')


    <section class="page-content">
        <div class="page-content-inner">

            <section class="panel">
                <div class="panel-heading">
                    <a href="{{route('portal.gift.requests')}}" class="btn btn-warning float-right" style="margin-right: 10px;">VOLTAR</a>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">


                        </div>
                    </div>


                    <section class="panel panel-with-borders">
                        <div class="panel-body">
                            <div class="row">

                                <div class="col-lg-4 col-md-12 col-sm-12">
                                    <div class="col-md-12 text-center"><img src="{{asset('img/pedidos-icon.png')}}" style="width: 250px;" id="photoVIew"></div>
                                    <div class="col-md-12"><hr></div>





                                    <br>

                                </div>
                                <div class="col-md-6">
                                    <h1 style="display: block">
                                        DADOS DO PEDIDO
                                    </h1>
                                    <p style="font-size: 18px;"><span class="label label-info">ID: #{{$request->id}}</span></p>
                                    <p style="font-size: 18px;"><span class="label label-important">DATA:</span> {{date('d/m/Y H:i', strtotime($request->created_at))}}</p>
                                    <p style="font-size: 18px;"><span class="label label-important">Total:</span> R$ {{number_format($request->total, 2, ',', '.')}} </p>
                                    <p style="font-size: 18px;"><span class="label label-important">Forma de Pagamento:</span> Cartão de Crédito </p>
                                    <p style="font-size: 18px;"><span class="label label-important">Parcelamento:</span> {{$request->payment_parcels}} </p>
                                    <p style="font-size: 18px;"><span class="label label-warning">STATUS: {{\App\ConfigApp::GiftRequetsStatus()[$request->status]}}</span> </p>
                                    <p style="font-size: 18px;"><a class="btn btn-primary-outline" href="{{$request->pdf}}" target="_blank">RECIBO</a> </p>

                                </div>

                            </div>


                            <div class="row">
                                <hr>
                                <h2>PRODUTOS</h2>
                                <hr>

                                <div class="col-md-12">

                                    <table class="table table-bordered table-responsive">
                                        <thead>
                                        <tr class="text-center">
                                            <td width="10%">Foto</td>
                                            <td width="25%">Nome</td>
                                            <td width="10%">Valor</td>
                                            <td width="10%">Quantidade</td>
                                            <td width="20%">Tamanho</td>
                                            <td width="20%">Modelo</td>
                                            <td width="5%">Subtotal</td>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        @foreach($request->gifts as $g)
                                            <tr>
                                                <td><img src="{{asset('img/portal/gifts/'.$g->photo)}}" style="width: 70px; height: 70px;"></td>
                                                <td>{{$g->name}}</td>
                                                <td>{{number_format($g->price,2,',','.')}}</td>
                                                <td>{{$g->amount}}</td>
                                                <td>
                                                    {{$g->size}}
                                                </td>
                                                <td>
                                                    {{$g->model}}
                                                </td>
                                                <?php $subtotal = $g->price * $g->amount; ?>
                                                <td>
                                                    {{number_format($subtotal,2,',', '.')}}
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
                <div class="panel-footer">

                </div>
            </section>

        </div>
        <div class="panel-footer">
        </div>
    </section>


    </div>
    </section>

@endsection