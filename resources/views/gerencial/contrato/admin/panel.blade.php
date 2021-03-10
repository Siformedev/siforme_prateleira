@extends('gerencial.inc.layout')

@section('content')

    <section class="page-content">
        <div class="page-content-inner">

            <!--  -->
            <section class="panel">
                <div class="panel-heading">
                    <div class="col-md-10">
                        <h3>Gerenciar Contrato</h3>
                        <h4>{{$contract->name}} - {{$contract->institution}} - {{\App\ConfigApp::MesConclusao()[$contract->conclusion_month]}}/{{$contract->conclusion_year}}</h4>
                        <h5>#{{$contract->code}}</h5>
                    </div>
                    <div class="col-md-2">
                        <a href="javascript:window.history.back();" class="btn btn-info btn-block"><i class="icmn icmn-arrow-left"></i> Voltar</a>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-body">
                </div>
            </section>
            <!-- End  -->

            <!--  -->
            <section class="panel">
                <div class="panel-body">
                    <div class="row text-center">
                        <div class="col-md-6 col-lg-4 col-xl-3">
                            <a href="{{route('gerencial.contrato.admin.dashboard', ['contract' => $contract->id])}}" class="btn btn-default font-size-80 width-250" style="background: #953b39; margin-bottom: 30px; ">
                                <i class="icmn icmn-pie-chart3"></i>
                                <p class="font-size-20">PAINEL</p>
                            </a>
                        </div>
                        <div class="col-md-6 col-lg-4 col-xl-3">
                            <a href="{{route('gerencial.contrato.admin.formings',['contract' => $contract->id])}}" class="btn btn-default font-size-80 width-250" style="background: #4caf50; margin-bottom: 30px;">
                                <i class="icmn icmn-users"></i>
                                <p class="font-size-20">Formandos</p>
                            </a>
                        </div>
                        <div class="col-md-6 col-lg-4 col-xl-3">
                            <a href="{{route('gerencial.contrato.admin.prod',['contract' => $contract->id])}}" class="btn btn-default font-size-80 width-250" style="background: #03a9f4; margin-bottom: 30px; ">
                                <i class="icmn icmn-cart5"></i>
                                <p class="font-size-20">Produtos e Serviços</p>
                            </a>
                        </div>
                        <div class="col-md-6 col-lg-4 col-xl-3">
                            <a href="{{route('gerencial.contrato.expenses', ['contract' => $contract->id])}}" class="btn btn-default font-size-80 width-250" style="background: #000080; margin-bottom: 30px;">
                                <i class="icmn icmn-price-tag"></i>
                                <p class="font-size-20">Gastos</p>
                            </a>
                        </div>
                        <div class="col-md-6 col-lg-4 col-xl-3">
                            <a href="{{route('gerencial.contrato.admin.finance',['contract' => $contract->id])}}" class="btn btn-default font-size-80 width-250" style="background: #3C510C; margin-bottom: 30px;">
                                <i class="icmn icmn-list2"></i>
                                <p class="font-size-20">Extrato Financeiro</p>
                            </a>
                        </div>
                        <div class="col-md-6 col-lg-4 col-xl-3">
                            <a href="" class="btn btn-default font-size-80 width-250" style="background: #795548; margin-bottom: 30px;">
                                <i class="icmn icmn-file-empty"></i>
                                <p class="font-size-20">Contrato Comissão</p>
                            </a>
                        </div>

                        <div class="col-md-6 col-lg-4 col-xl-3">
                            <a href="" class="btn btn-default font-size-80 width-250" style="background: #ff5722; margin-bottom: 30px;">
                                <i class="icmn icmn-bullhorn"></i>
                                <p class="font-size-20">Chamados</p>
                            </a>
                        </div>
                        <div class="col-md-6 col-lg-4 col-xl-3">
                            <a href="" class="btn btn-default font-size-80 width-250" style="background: #9c27b0; margin-bottom: 30px;">
                                <i class="icmn icmn-file-presentation2"></i>
                                <p class="font-size-20">Orçamento</p>
                            </a>
                        </div>
                        <div class="col-md-6 col-lg-4 col-xl-3">
                            <a href="" class="btn btn-default font-size-80 width-250" style="background: #00bcd4; margin-bottom: 30px;">
                                <i class="icmn icmn-bag2"></i>
                                <p class="font-size-20">Brindes</p>
                            </a>
                        </div>
                        <div class="col-md-6 col-lg-4 col-xl-3">
                            <a href="{{route('gerencial.contrato.admin.config_tipo_pagamento',['contract' => $contract->id])}}" class="btn btn-default font-size-80 width-250" style="background: #3C510C; margin-bottom: 30px;">
                                <i class="icmn icmn-cog"></i>
                                <p class="font-size-20">Configurações</p>
                            </a>
                        </div>
                    </div>
                </div>
            </section>
            <!-- End  -->



        </div>

        <!-- Page Scripts -->
        <script>
            $(function(){

            });
        </script>
        <!-- End Page Scripts -->

    </section>

@endsection