@extends('portal.inc.layout')

@section('content')


    <section class="page-content">
        <div class="page-content-inner">


            @if(Session::has('add'))
                <div class="alert alert-success">
                    {{Session::get('add')}}!
                </div>
            @endif

            <section class="panel">
                <div class="panel-heading">

                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <h1 style="display: block">
                                Carrinho de Compras

                                <a href="{{route('portal.gifts')}}" class="btn btn-warning float-right">CONTINUAR COMPRANDO</a>
                            </h1>
                        </div>
                    </div>

                    @if(session('gifts.checkout'))
                            <section class="panel panel-with-borders">
                                <div class="panel-body">
                                    <div class="row">

                                        <form action="{{route('portal.gifts.pay.session')}}" method="post">
                                            {{csrf_field()}}
                                            <table class="table table-bordered table-responsive">
                                                <thead>
                                                <tr class="text-center">
                                                    <td width="10%">Foto</td>
                                                    <td width="25%">Nome</td>
                                                    <td width="10%">Valor</td>
                                                    <td width="10%">Quantidade</td>
                                                    <td width="20%">Tamanho</td>
                                                    <td width="20%">Modelo</td>
                                                    <td width="5%">Excluir</td>
                                                </tr>
                                                </thead>
                                                <tbody>

                                                @foreach(session('gifts.checkout') as $g)
                                                    @php
                                                        if($g->id == 17){
                                                            $id17 = true;
                                                        }
                                                    @endphp
                                                    <tr>
                                                        <td><input type="hidden" name="prod[{{$g->id}}][id]" value="{{$g->id}}"> <img src="{{asset('img/portal/gifts/'.$g->photo)}}" style="width: 70px; height: 70px;"></td>
                                                        <td>{{$g->name}}</td>
                                                        <td>{{number_format($g->price,2,',','.')}}</td>
                                                        <td><input class="form-control" type="number" min="1" @if($g->id == 17) max="1" @endif name="prod[{{$g->id}}][amount]" value="1"></td>
                                                        <?php
                                                            $select_size = explode(',', $g->size)
                                                        ?>
                                                        <td>
                                                            <select class="form-control" name="prod[{{$g->id}}][size]">
                                                                @foreach($select_size as $s)
                                                                    <option value="{{$s}}">{{$s}}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                        <?php
                                                        $select_models = explode(',', $g->models)
                                                        ?>
                                                        <td>
                                                            <select class="form-control" name="prod[{{$g->id}}][models]">
                                                                @foreach($select_models as $m)
                                                                    <option value="{{$m}}">{{$m}}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                        <td class="text-center"><a href="?del={{$g->id}}"><img src="{{asset('img/delete-v1.png')}}" style="width: 50px;"></td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                            @if(@$id17)
                                                    <div class="alert alert-danger">
                                                        Formandos que efetuarem a compra da pré-reserva para Maresias e não estiver adimplente com a formatura até o dia 11/10 ás 23:59 terá sua reserva cancelada e o valor reembolsado posteriormente.
                                                    </div>
                                            @endif
                                            <p><button class="btn btn-primary btn-block">FECHAR PEDIDO</button></p>
                                        </form>

                                    </div>
                                </div>
                            </section>
                    @else
                        <section class="panel panel-with-borders">
                            <div class="panel-heading">
                                <h5>Nenhum produto adicionado até o momento...</h5>
                            </div>
                        </section>
                    @endif
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
