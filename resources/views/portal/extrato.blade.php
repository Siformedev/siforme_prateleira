@extends('portal.inc.layout')
@section('content')
<section class="page-content">
    <div class="page-content-inner">
        @foreach($pedidos as $pedido)
        <section class="panel">
            <div class="panel-heading">
                <div class="col-lg-9 col-md-8 col-sm-6">
                    <h3><a href="{!! route('portal.extrato.produto', ['prod' => $pedido->id]) !!}">{{$pedido->name}} </a></h3>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6 float-left">
                    <table class="table table-bordered float-left color-info">
                        <tr>
                            <th scope="row">Codigo:</th>
                            <td>#{{str_pad($pedido->id, 8, '0', STR_PAD_LEFT)}}</td>
                            <th scope="row">Quantidade:</th>
                            <td>{{$pedido->amount}}</td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-2 col-md-3 col-sm-4">
                        <img src="{{asset($pedido->img)}}" style="width: 100px; height: 100px;" class="img-responsive img-thumbnail img-circle"></div>
                    <div class="col-lg-6 col-md-4 col-sm-4">
                        <b>Descrição:</b> <br>
                        {{$pedido->description}}<br>
                        @if($pedido->withdrawn > 0)
                        <span class="label label-info font-size-18" style="padding: 10px; margin-top: 10px;">Retirado {{ $pedido->amount }} convite (s)</span>
                        @endif
                    </div>
                    <div class="col-lg-4 col-md-5 col-sm-4" style="font-size: 16px;">
                        <table class="table table-bordered">
                            <tr>
                                <th scope="row">Data do pedido:</th>
                                <td>{{Carbon\Carbon::parse($pedido->created_at)->format('d/m/Y')}}</td>
                            </tr>
                            <tr>
                                <th scope="row">Valor Total:</th>
                                <td>R$ {{number_format($pedido->valorFinal(),2,",", ".")}}</td>
                            </tr>
                            <tr>
                                <th scope="row">Dia Pagamento:</th>
                                <td>{{$pedido->payday}}</td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <a href="{!! route('portal.extrato.produto', ['prod' => $pedido->id]) !!}" class="btn btn-success btn-block"><i class="fa fa-search"></i> Detalhes e Boletos </a>
                                    <a href="{!! route('portal.extrato.cancel', ['prod' => $pedido->id]) !!}" class="btn btn-primary btn-block"><i class="fa fa-remove"></i> Cancelar Pedido </a>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </section>
        @endforeach
        @if(count($pedidos)<1)
        <section class="panel">
            <div class="panel-heading">
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <h1>Não foram encontrados registros no seu extrato.</h1>
                    </div>
                </div>
            </div>
            <div class="panel-footer">
            </div>
        </section>
        @endif
    </div>
</section>
@endsection