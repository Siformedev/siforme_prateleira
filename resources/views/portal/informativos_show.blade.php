@extends('portal.inc.layout')

@section('content')


    <section class="page-content">
        <div class="page-content-inner">

            <section class="panel">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-1" style="font-size: 50px"><i class="icmn-bell3" style="margin-right: 20px"></i></div>
                        <div class="col-md-11">
                            <h3>{{$informativo['titulo']}}</h3>
                            <h6>{{$informativo['created_at']}}</h6>
                        </div>
                    </div>
                    <div style="float: right"><a class="btn btn-default" href="{{route('portal.informativos')}}">Voltar</a> </div>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <hr>
                        <div class="col-md-12">
                            <b>Descrição:</b> <br>
                            {!! nl2br($informativo['descricao']) !!}
                        </div>
                    </div>

                    <hr>


                    <h3>Dados do Atendimento</h3>

                    <hr>

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