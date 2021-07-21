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
                            <h1>Comissão de Formatura</h1>
                        </div>
                    </div>
                </div>
                <div class="panel-footer">
                    <span>Conheça sua comissão de formatura</span>
                </div>
            </section>

            @foreach($comissao as $c)
                <div class="col-md-6 col-lg-4">
                    <section class="panel" style="">
                        <div class="panel-body">


                            <div class="span3 well text-center">
                                <a href="#aboutModal" data-toggle="modal" data-target="#myModal{{$c->id}}"><img src="{{asset($c->img)}}" name="aboutme" width="140" height="140" class="img-circle"></a>
                                <br><br>
                                <h3>{{$c->nome}} {{$c->sobrenome}}</h3>
                                <span class="label label-info">{{\App\Course::find($c->curso_id)->name}}</span>
                                <span class="label label-success">{{\App\ConfigApp::Periodos()[$c->periodo_id]}}</span>
                                <br><br>
{{--                                <div class="modal-footer text-center">--}}
{{--                                    <a href="mailto:{{$c->email}}" type="button" class="btn btn-default">Enviar email</a>--}}
{{--                                </div>--}}
                                <!--
                                <em data-toggle="modal" data-target="#myModal{{$c->id}}" style="cursor: pointer">Clique para mais detalhes</em>
                                -->
                            </div>

                            <!-- Modal -->
                            <div class="modal fade" id="myModal{{$c->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                                <img src="{{asset($c->img)}}" name="aboutme" width="140" height="140" border="0" class="img-circle"></a>
                                                <h3 class="media-heading">{{$c->nome}} {{$c->sobrenome}}<small></small></h3>
                                                <span><strong> </strong></span>
                                                <span class="label label-info">{{\App\Course::find($c->curso_id)->name}}</span>
                                                <span class="label label-success">{{\App\ConfigApp::Periodos()[$c->periodo_id]}}</span>
                                                <!--<span class="label label-warning">Outros</span>-->
                                            <hr>
                                            <!--
                                            <center>
                                                <p class="text-left"><strong>Resposabilidades:</strong><br>
                                                    Habitasse parturient amet ac lacus adipiscing dis nec, ut purus. Eu pulvinar dictumst, amet tempor pellentesque, pulvinar lectus scelerisque a et? Rhoncus ultricies turpis diam porttitor dignissim, dis elementum cursus. Amet montes pulvinar parturient cursus! Augue. Non tincidunt mid integer ultricies mauris? Lorem habitasse, pellentesque tristique nunc et.
                                                </p>
                                                <br>
                                            </center>
                                            -->
                                        </div>
{{--                                        <div class="modal-footer text-center">--}}
{{--                                            <a href="mailto:{{$c->email}}" type="button" class="btn btn-default">Enviar email</a>--}}
{{--                                        </div>--}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            @endforeach
            @if($comissao->count() <= 0)
                <div class="col-md-12 col-lg-12">
                    <section class="panel" style="">
                        <div class="panel-body">
                            <span style="display: block; font-size: 18px; ">Em breve, será concluído o cadastro de sua comissão de formatura...</span>
                        </div>
                    </section>
                </div>
            @endif()


        </div>
    </section>

@endsection