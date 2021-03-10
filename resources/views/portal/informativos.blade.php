@extends('portal.inc.layout')

@section('content')


    <section class="page-content">
        <div class="page-content-inner">

            <section class="panel">
                <div class="panel-heading">

                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <h1>Boletins Informativos</h1>
                        </div>
                    </div>
                </div>
                <div class="panel-footer">
                </div>
            </section>

            <?php
            $informativos = $contrato->informativos()->orderBy('created_at', 'desc')->get();
            $i=0;
            ?>

            @foreach($informativos as $informativo)

                @php
                    $i++;
                    $bg = '';
                    $color = '';
                    if($informativo->status == 0){
                        $bg = 'background: #f1f1f1';
                        $color = '#ff9800';
                    }
                @endphp
                <section class="panel" style="{{$bg}}">
                    <div class="panel-heading">
                        <h3>
                            <a href="{{route('portal.informativos.show', ['informativo' => $informativo['id']])}}">{{$informativo['titulo']}}</a>
                        </h3>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-1">
                                <span style="font-size: 50px"><i class="icmn-bell3"
                                                                 style="color: {{$color}}"></i></span>
                            </div>
                            <div class="col-md-8" style="font-size: 16px;">
                                {{\App\Helpers\StringHelper::limitarTexto(strip_tags($informativo['descricao']), 250)}}
                            </div>
                            <div class="col-md-3" style="font-size: 16px;">
                                <table class="table table-bordered">
                                    <tr>
                                        <th scope="row">Data:</th>
                                        <td>{{$informativo['created_at']}}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </section>
            @endforeach
            @if($i==0)
                <section class="panel" style="">

                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-1">
                                <span style="font-size: 50px"><i class="icmn-bell3"
                                                                 ></i></span>
                            </div>
                            <div class="col-md-8" style="font-size: 16px;">
                                Nenhum Boletim Cadastrado até o momento
                            </div>

                    </div>
                </section>
            @endif

        </div>
    </section>

@endsection