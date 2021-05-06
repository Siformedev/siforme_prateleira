@extends('portal.inc.layout')

@section('content')


    <section class="page-content">
        <div class="page-content-inner">

            @if(Session::has('process_message'))
                <div class="alert alert-danger">{{Session::get('process_message')}}! Código:
                    LR-{{Session::get('process_lr')}}</div>
            @endif

            @if(Session::has('process_success_msg'))
                <div class="alert alert-success">Pagamento {{Session::get('process_success_msg')}}!</div>
            @endif

            <section class="panel">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-lg-2 col-md-3 col-sm-3"><a class="btn btn-default" href="{{route('portal.polls.index')}}">Voltar</a> </div>
                        <div class="col-lg-10 col-md-9 col-sm-9">
                            <h3>Atração Musical</h3>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-2 col-md-3 col-sm-12">
                            <img src="" style="width: 100px; height: auto;">
                        </div>
                        <div class="col-lg-10 col-md-9 col-sm-12">
                            <b>Descrição:</b> <br>
                            Vote na atração musical de sua preferência para o Baile de formatura
                            <!--
                            <div class="row">
                                <div class="col-md-12">
                                    <hr>
                                    <span>Percentual já Pago (75%)</span>
                                    <progress class="progress progress-success progress-striped" value="75" max="100">75%</progress>
                                </div>
                            </div>
                            -->
                        </div>

                    </div>

                    <hr>

                    <h3>Escolha abaixo:</h3>

                    <div class="row">
                        <div class="col-md-12" style="font-size: 16px;">
                            <form>
                            <table class="table table-striped" style="width: 100% !important;">
                                <tbody>

                                    <tr>
                                        <td><input type="radio" name="resp" class=""> - Banda de Formatura</td>
                                    </tr>
                                    <tr>
                                        <td><input type="radio" name="resp" class=""> - Bateria Escola de Samba</td>

                                    </tr>
                                    <tr>
                                        <td><input type="radio" name="resp" class=""> - Cover Mamonas </td>

                                    </tr>
                                    <tr>
                                        <td><input type="radio" name="resp" class=""> - Banda Época</td>

                                    </tr>

                                </tbody>
                            </table>
                                <button class="btn btn-block btn-warning">ENVIAR MEU VOTAR</button>
                            </form>
                        </div>
                    </div>


                </div>
                <div class="panel-footer">



                </div>


            </section>

        </div>

    </section>


@endsection
