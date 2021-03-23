@extends('portal.inc.layout')

@section('content')



    <section class="page-content">
        <div class="page-content-inner">

            @if(Session::has('process_success_msg'))
                <div class="alert alert-success">Pagamento {{Session::get('process_success_msg')}}! Obrigado por sua compra!</div>
            @endif

            <section class="panel">
                <div class="panel-heading">
                    <h1>
                        Pedidos
                        <a href="{{route('portal.gifts')}}" class="btn btn-primary-outline float-right">LOJINHA</a>
                    </h1>

                </div>
{{--                <div class="panel-footer">--}}
{{--                    --}}
{{--                </div>--}}
            </section>

            @foreach($requests as $request)

                <section class="panel panelClicked" onclick="window.location.href = '{{route('portal.gift.request', ['id' => $request->id])}}'">
                    <div class="panel-body">
                        <div class="row text-center">
                            <div class="col-md-1">
                                <span style="font-size: 50px"><img src="{{asset('img/pedidos-icon.png')}}" style="width: 60px;"></span>
                            </div>
                            <div class="col-md-1" style="font-size: 16px;"><div class="label label-info" style="font-size: 18px; line-height: 60px; width: 80px">#{{$request->id}}</div> </div>
                            <div class="col-md-2 text-center" style="font-size: 28px;">
                                <span style="font-size: 18px; font-weight: bold; display: block; border-bottom: 1px solid #1f7e9a">TOTAL</span>
                                {{number_format($request->total,2, ',', '.')}}
                            </div>
                            <div class="col-md-2 text-center" style="font-size: 28px;">
                                <span style="font-size: 18px; font-weight: bold; display: block; border-bottom: 1px solid #1f7e9a">QUANT</span>
                                {{number_format($request->gifts->count(),0)}}
                            </div>
                            <div class="col-md-2 text-center" style="font-size: 28px;">
                                <span style="font-size: 18px; font-weight: bold; display: block; border-bottom: 1px solid #1f7e9a">DATA</span>
                                {{date('d/m/Y', strtotime($request->created_at))}}
                            </div>
                            <div class="col-md-4 text-center" style="font-size: 28px;">
                                <span style="font-size: 18px; font-weight: bold; display: block; border-bottom: 1px solid #1f7e9a">STATUS</span>
                                <div class="label label-info">{{\App\ConfigApp::GiftRequetsStatus()[$request->status]}}</div>
                            </div>

                        </div>
                    </div>
                </section>
            @endforeach


        </div>
    </section>

@endsection