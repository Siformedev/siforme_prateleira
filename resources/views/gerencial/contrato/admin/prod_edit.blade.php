@extends('gerencial.inc.layout')

@section('content')

    <section class="page-content">
        <div class="page-content-inner">

            @if(session()->has('parcel_error'))
                <div class="alert alert-danger">
                    <ul>
                        <li>{{ session('parcel_msg') }}</li>
                    </ul>
                </div>
            @endif

                @if(session()->has('parcel_ok'))
                    <div class="alert alert-success">
                        <ul>
                            <li>{{ session('parcel_msg') }}</li>
                        </ul>
                    </div>
            @endif
            <!--  -->
            <section class="panel">
                <div class="panel-heading">
                    <div class="col-md-10">
                        <h3>
                            Gerenciar Produto
                            <a href="javascript:window.history.back();" class="btn btn-warning float-right"><i class="icmn icmn-arrow-left"></i> Voltar</a>
                        </h3>

                    </div>
                    <div class="col-md-2">

                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-body">
                </div>
            </section>
            <!-- End  -->


            <section class="panel panel-with-borders">
                <form method="post" action="{{route('gerencial.contrato.admin.prod.edit.post', ['prod' => $prod->id])}}">
                <div class="panel-heading">
                    <h5>{{ $prod->name }}</h5>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-2"><img id="img-prod_{{ $prod->id }}" class="img-responsive img-thumbnail img-circle img-prod" style="width: 150px; height: 150px;" src="{{ asset($prod->img) }}"></div>
                        <div class="col-md-4">
                            <p><textarea name="description" id="description" cols="30" class="form-control" rows="10">{!! nl2br($prod->description)  !!}</textarea></p>


                        </div>
                        <div class="col-md-4">
                            @if($productValues == false)
                                <div class="col-md-12 col-sm-12 text-center">
                                    <section class="panel panel-with-borders" style="min-height: 320px;">
                                        <div class="panel-body">
                                            <h5><img src="https://cdn0.iconfinder.com/data/icons/50-payment-system-icons-2/480/Boleto.png" height="30"> BOLETO BANCÁRIO</h5>
                                            <hr>
                                            <span style="font-size: 13px;"> NENHUM VALOR ENCONTRADO </span></span>
                                            <hr>
                                        </div>
                                    </section>
                                </div>
                            @endif()
                            @if($productValues)
                            @foreach($productValues as $p)



                                <?php
                                if(isset($p['discounts'][1]['maximum_parcels'])){
                                    $descontoAVista = $p['discounts'][1]['value'] / 100;
                                    $valorDescontoAVista = $p['values']['value'] - ($descontoAVista * $p['values']['value']);
                                }
                                ?>



                                <div class="col-md-12 col-sm-12 text-center">
                                    <section class="panel panel-with-borders" style="min-height: 320px;">
                                        <div class="panel-body">
                                            <h5><img src="https://cdn0.iconfinder.com/data/icons/50-payment-system-icons-2/480/Boleto.png" height="30"> BOLETO BANCÁRIO</h5>
                                            <hr>
                                            <span style="font-size: 13px;"> À Vista no Boleto @if(isset($valorDescontoAVista)) C/ {{ $descontoAVista*100 }}% de desconto @endif <br><span class="label label-success margin-inline margin-3" style="font-size: 24px">R$ {{ number_format( (isset($valorDescontoAVista)?$valorDescontoAVista:$p['values']['value']) , 2, ",", ".") }}</span></span>
                                            <hr>



                                            <span>
                                                @php
                                                    $max_parcela_desc = 0;
                                                @endphp
                                                @if(isset($p['discounts']))
                                                    @foreach($p['discounts'] as $desc)

                                                        @if($desc['maximum_parcels'] > 1)
                                                            @php
                                                                if ($desc['maximum_parcels'] > $max_parcela_desc){
                                                                    $max_parcela_desc = $desc['maximum_parcels'];
                                                                    $max_parcela_porc = $desc['value'];
                                                                }
                                                            @endphp
                                                            <span style="font-size: 9px"> ou R$ <b>{{ number_format($p['values']['value'] - (($desc['value'] / 100) * $p['values']['value']), 2, ",", ".") }}</b> em até {{ $desc['maximum_parcels'] }}X com <b>{{ $desc['value'] }}%</b> de desconto </span> <br>
                                                        @endif
                                                    @endforeach
                                                @endif

                                                @foreach($p['max_parcels'] as $parc)
                                                    @if($parc['parcelas'] > $max_parcela_desc)
                                                        <span style="font-size: 8px"> ou R$ {{ number_format($p['values']['value'], 2, ",", ".") }} em até {{ $parc['parcelas']}}X com o primeira para {{ date('d/m', strtotime($parc['priPagamento'])) }} </span><br>
                                                    @else
                                                        <span style="font-size: 8px"> ou R$ {{ number_format(($p['values']['value'] - ($max_parcela_porc / 100) * $p['values']['value']), 2, ",", ".") }} em até {{ $parc['parcelas']}}X com o primeira para {{ date('d/m', strtotime($parc['priPagamento'])) }} </span><br>
                                                    @endif
                                                @endforeach
                                            </span>
                                        </div>
                                    </section>
                                </div>
                        </div>
                    </div>
                    @php
                        unset($descontoAVista, $valorDescontoAVista);
                    @endphp
                    @endforeach()
                    @endif
                        </div>
            </section>

                <section class="panel panel-with-borders">
                    <div class="panel-heading">
                        <h5>PARCELAS</h5>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            
                                {{csrf_field()}}
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <td><input class="form-control" type="datetime-local" name="date_start" placeholder="Data de Início"></td>
                                            <td> <input class="form-control" type="datetime-local" name="date_end"  placeholder="Data de Término"></td>
                                            <td><input class="form-control" type="text" placeholder="Valor (R$)" name="value"></td>
                                            <td><input class="form-control" type="number" placeholder="Máximo de Parcelas" name="max_parcels"></td>
                                            <td><button class="btn btn-success">Salvar</button> </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </form>
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <td>ID#</td>
                                    <td>Data de Inicio</td>
                                    <td>Data de Término</td>
                                    <td>Valor</td>
                                    <td>Máximo de Parcelas</td>
                                    <td>Excluir</td>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($parcels as $p)
                                <tr>
                                    <td>{{$p->id}}</td>
                                    <td>{{date("d/m/Y H:i:s", strtotime($p->date_start))}}</td>
                                    <td>{{date("d/m/Y H:i:s", strtotime($p->date_end))}}</td>
                                    <td>{{number_format($p->value,2,",", ".")}}</td>
                                    <td>{{number_format($p->maximum_parcels,0)}}</td>
                                    <td><a href="{{route('gerencial.contrato.admin.prod.edit.parcel.delete', ['prod'=> $prod->id, 'parcel' => $p->id])}}"><img src="{{asset('img/delete-v1.png')}}" style="width: 25px;"></a></td>
                                </tr>
                                @endforeach()
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>




        </div>


    </section>

@endsection