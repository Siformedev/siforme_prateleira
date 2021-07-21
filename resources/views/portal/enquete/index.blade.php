@extends('portal.inc.layout')

@section('content')



    <section class="page-content">
        <div class="page-content-inner">

            <section class="panel">
                <div class="panel-heading">

                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-10">
                            <h1>Enquetes</h1>
                        </div>
                    </div>


                </div>
            </section>

            <div class="col-lg-12">

                @if(session()->has('msg'))
                    <div class="alert alert-success">{{session()->get('msg')}}</div>
                @endif
                <div class="margin-bottom-50">
                    <div class="nav-tabs-horizontal">
{{--                        <ul class="nav nav-tabs" role="tablist">--}}
{{--                            <li class="nav-item">--}}
{{--                                <a class="nav-link active" href="javascript: void(0);" data-toggle="tab" data-target="#alvo1" role="tab" aria-expanded="true">Atendimentos Abetos</a>--}}
{{--                            </li>--}}
{{--                            <li class="nav-item">--}}
{{--                                <a class="nav-link" href="javascript: void(0);" data-toggle="tab" data-target="#alvo2" role="tab" aria-expanded="false">Atendimentos Finalizados</a>--}}
{{--                            </li>--}}
{{--                        </ul>--}}
                        <div class="tab-content padding-vertical-20">

                            <div class="tab-pane active" id="alvo1" role="tabpanel" aria-expanded="true">
                                @php
                                    $i1=0;
                                @endphp
                                @foreach($surveys as $survey)
                                    @php
                                        $i1++;
                                        $answer = App\SurveyAnswer::where(['forming_id' => auth()->user()->userable->id, 'survey_id' => $survey->id])->get();
                                        $class = '';
                                        if($answer->count() == 0){
                                            $class = 'answered';
                                        }
                                    @endphp
                                <section class="panel pn-hover-chamado" style="cursor: pointer" onclick="window.location.href = '{{route('portal.survey.show', ['survey' => $survey->id])}}'">
                                    <div class="panel-heading" >
                                        <h3><a href="{{route('portal.survey.show', ['survey' => $survey->id])}}">{{$survey->title}}</a></h3>
                                    </div>
                                    <div class="panel-body">
                                        <div class="row">
                                            <style>
                                                .answered {
                                                    -webkit-filter: grayscale(100%);
                                                    filter: grayscale(100%);
                                                    filter: gray; /* IE */
                                                }
                                            </style>
                                            <div class="col-md-1">
                                                <span style="font-size: 50px"><img class="{{$class}}" src="https://img2.gratispng.com/20180807/czq/kisspng-poll-everywhere-learning-georgia-abe-s-self-storag-erledigt24-com-icon_web-erledigt24-com-5b69a373dea635.897813561533649779912.jpg" style="width: 80px;"></span>
                                            </div>
                                            <div class="col-md-5">
                                                <b>Descrição:</b> <br>
                                                {{\App\Helpers\StringHelper::limitarTexto(strip_tags(nl2br($survey->description)), 250)}}

                                            </div>
                                        </div>
                                    </div>
                                </section>
                                @endforeach
                                @if($i1==0)
                                    <section class="panel">

                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-md-1">
                                                    <span style="font-size: 50px"><i class="icmn-alarm" style="color: lightgrey"></i></span>
                                                </div>
                                                <div class="col-md-11">
                                                    Nenhuma Enquete ativa no momento
                                                </div>
                                            </div>
                                        </div>
                                    </section>
                                @endif

                            </div>

                        </div>
                    </div>
                </div>
            </div>










        </div>
    </section>

@endsection
