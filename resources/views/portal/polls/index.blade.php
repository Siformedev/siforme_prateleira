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
                            <h1>ENQUETES</h1>
                        </div>
                    </div>


                </div>
                <div class="panel-footer">
                </div>
            </section>

            <div class="col-lg-12">

                <br>
                <div class="margin-bottom-50">
                    <div class="nav-tabs-horizontal">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" href="javascript: void(0);" data-toggle="tab" data-target="#alvo1" role="tab" aria-expanded="true">Ativas</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="javascript: void(0);" data-toggle="tab" data-target="#alvo2" role="tab" aria-expanded="false">Encerradas</a>
                            </li>
                        </ul>
                        <div class="tab-content padding-vertical-20">

                            <div class="tab-pane active" id="alvo1" role="tabpanel" aria-expanded="true">
                                @php
                                    $i1=0;
                                @endphp
                                @for($ii=1; $ii<=3; $ii++)
                                    @php
                                        $i1++;
                                    $arr = [
                                        1 => ['title' => "Atração Musical", 'description' => "Vote na atração musical de sua preferência para o Baile de formatura"],
                                        2 => ['title' => "Tema da Festa", 'description' => "Vote no tema para o Baile de formatura"],
                                        3 => ['title' => "Combos de Bar", 'description' => "Vote entre os combos de bar para o Baile de formatura"]
                                    ];
                                    @endphp
                                <section class="panel pn-hover-chamado" style="cursor: pointer" onclick="window.location.href = ''">
                                    <div class="panel-heading" >
                                        <h3><a href="">{{$arr[$ii]['title']}}</a></h3>
                                    </div>
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-md-1">
                                                <span style="font-size: 50px"><i class="icmn-list2" style="color: green"></i></span>
                                            </div>
                                            <div class="col-md-8">
                                                <b>Descrição:</b> <br>

                                                {{$arr[$ii]['description']}}


                                            </div>

                                            <div class="col-md-3" style="font-size: 16px;">
                                                <table class="table table-bordered">
                                                    <tr>
                                                        <th scope="row">Data de Encerramento:</th>
                                                        <td>22/07/2019 as 23h00</td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                                @endfor
                                @if($i1==0)
                                    <section class="panel">

                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-md-1">
                                                    <span style="font-size: 50px"><i class="icmn-bullhorn" style="color: lightgrey"></i></span>
                                                </div>
                                                <div class="col-md-11">
                                                    Nenhum Atendimento foi solicitado até o momento
                                                </div>
                                            </div>
                                        </div>
                                    </section>
                                @endif

                            </div>

                            <div class="tab-pane" id="alvo2" role="tabpanel" aria-expanded="false">

                            </div>

                        </div>
                    </div>
                </div>
            </div>










        </div>
    </section>

@endsection