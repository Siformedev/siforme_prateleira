@extends('gerencial.inc.layout')

@section('content')


    <section class="page-content">
        <div class="page-content-inner">

            <section class="panel">
                <div class="panel-heading">

                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-10">
                            <h1>Cadastrar Nova Despesa</h1>
                        </div>
                        <div class="col-md-2">
                            <a href="{{route('gerencial.contrato.expenses', ['contract' => 7])}}"
                               class="btn btn-info btn-block"><i class="icmn icmn-arrow-left"></i> Voltar</a>
                        </div>
                    </div>


                </div>
            </section>


            <section class="panel">
                <div class="panel-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if(Session::has('msg_error'))
                            <div class="alert alert-danger">
                                <ul>
                                    <li>{!! Session::get('msg_error') !!}</li>
                                </ul>
                            </div>
                     @endif

                    {!! Form::open(['route' => ['gerencial.contrato.expenses.store', 'contract' => 7], 'enctype' => "multipart/form-data"]) !!}

                    <div class="col-lg-12">
                        <div class="form-group">
                            {{ Form::label('name', 'Nome') }}
                            {{ Form::text('name', null, array_merge(['class' => 'form-control'])) }}
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="form-group">
                            {{ Form::label('description', 'Descrição') }}
                            {{ Form::textarea('description', null, array_merge(['class' => 'form-control'])) }}
                        </div>
                    </div>

                    <div class="col-lg-5">
                        <div class="form-group">
                            {{ Form::label('value', 'Valor') }}
                            {{ Form::text('value', null, array_merge(['class' => 'form-control', 'id' => 'real'])) }}
                        </div>
                    </div>

                        <div class="col-lg-5">
                            <div class="form-group">
                                {{ Form::label('category_id', 'Categoria') }}
                                {{ Form::select('category_id', \App\ExpensesCategory::all()->pluck(['name']), null, array_merge(['class' => 'form-control', 'id' => 'category'])) }}
                            </div>
                        </div>

                    <div class="col-lg-2">
                        <div class="form-group">
                            {{ Form::label('paid', 'Pago') }}
                            {{ Form::select('paid', [0 => 'Não', 1 => "Sim"], null, array_merge(['class' => 'form-control', 'id' => 'paid'])) }}
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <hr>
                    </div>

                    <div class="col-lg-6">
                        <div class="form-group">
                            {{ Form::label('due_date', 'Data de Vencimento') }}
                            {{ Form::date('due_date', null, array_merge(['class' => 'form-control'])) }}
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="form-group">
                            {{ Form::label('payday', 'Data do Pagamento') }}
                            {{ Form::date('payday', null, array_merge(['class' => 'form-control'])) }}
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <hr>
                    </div>

                    <div class="col-lg-6">
                        <div class="form-group">
                            {{ Form::label('billing_file', 'Anexo da cobrança') }}
                            {{ Form::file('billing_file', null, array_merge(['class' => 'form-control'])) }}
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="form-group">
                            {{ Form::label('payment_file', 'Anexo do pagamento') }}
                            {{ Form::file('payment_file', null, array_merge(['class' => 'form-control'])) }}
                        </div>
                    </div>

                    <div class="col-md-12">
                        <hr>
                        <button type="submit" class="btn btn-success btn-block">Cadastrar</button>
                    </div>

                    <div class="clearfix"></div>


                    {!! Form::close() !!}

                </div>
            </section>


        </div>
    </section>

@endsection

@section('script')
    <script>
        $(document).ready(function(){
            $('#real').mask("#.##0,00", {reverse: true});
        });
    </script>
@endsection