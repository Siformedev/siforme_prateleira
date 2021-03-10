@extends('portal.inc.layout')

@section('content')


    <section class="page-content">
        <div class="page-content-inner">

            <section class="panel">
                <div class="panel-heading">
                    <h3>{{$survey->title}}</h3>
                    <div style="float: right"><a class="btn btn-default" href="{{route('portal.survey.index')}}">Voltar</a> </div>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-1">
                            <i class="icmn-bullhorn" style="font-size: 50px;" ></i>
                        </div>
                        <div class="col-md-11">
                            <b>Descrição:</b> <br>
                            {!! nl2br($survey->description) !!}
                        </div>
                    </div>
                    <hr>



{{--                    <div class="row">--}}
{{--                        <div class="col-md-12" style="font-size: 16px;">--}}
{{--                            <table class="table table-bordered">--}}
{{--                                <tr>--}}
{{--                                    <th scope="row">Data de abertura:</th>--}}
{{--                                    <td>{{$chamado['created_at']}}</td>--}}
{{--                                </tr>--}}
{{--                                <tr>--}}
{{--                                    <th scope="row">Data Limite:</th>--}}
{{--                                    <td>{{$chamado['data_limite']}}</td>--}}
{{--                                </tr>--}}
{{--                                <tr>--}}
{{--                                    <th scope="row">Assunto</th>--}}
{{--                                    <td>{{\App\ConfigApp::AssuntosChamados()[$chamado['assunto_chamado']]}}</td>--}}
{{--                                </tr>--}}
{{--                                <tr>--}}
{{--                                    <th scope="row">Status</th>--}}
{{--                                    <td>{{\App\ConfigApp::ChamadosStatus()[$chamado['status']]}}</td>--}}
{{--                                </tr>--}}
{{--                            </table>--}}
{{--                        </div>--}}
{{--                    </div>--}}
                    @if(!isset($answer))

                    <h3>Escolha uma alternativa abaixo:</h3>
                    <hr>
                    {!! Form::open() !!}
                    <div class="row">
                            @foreach($survey->questions as $question)
                                <div class="col-lg-12">
                                    <div class="input-group">
                                          <span class="input-group-addon" style="padding: 20px; font-size: 18px;">
                                             <input type="radio" aria-label="" name="question" value="{{$question->id}}"> {{$question->answer}}
                                          </span>
                                    </div><!-- /input-group -->
                                </div><!-- /.col-lg-12 -->

                            @endforeach
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-success btn-block">Enviar resposta</button>
                        </div>
                    </div>
                    {!! Form::close() !!}

                    @else
                        <div class="row text-center">
                            <br>

                        <div class="alert alert-warning">
                            Você já respondeu, obrigado!<br>
                        </div>

                            <br>

                            <div class="alert alert-success">
                            Sua resposta: {{$answer->questionAnswer->answer}}
                        </div>
                        </div>
                    @endif

                </div>
                <div class="panel-footer">

                </div>
            </section>
        </div>

    </section>

    <script type="text/javascript">
        $(function(){

        });
    </script>

@endsection
