@extends('portal.inc.layout')

@section('content')


    <section class="page-content">

        <div class="page-content-inner">

            <!-- Profile Header -->
            <nav class="top-submenu top-submenu-with-background">
                <div class="profile-header">
                    <div class="profile-header-info">
                        <div class="row">
                            <div class="col-xl-8 col-xl-offset-4">
                                <!--
                                <div class="width-100 text-center pull-right hidden-md-down">
                                    <h2>154</h2>
                                    <p>Followers</p>
                                </div>
                                <div class="width-100 text-center pull-right hidden-md-down">
                                    <h2>17</h2>
                                    <p>Posts</p>
                                </div>
                                -->
                                <div class="profile-header-title">
                                    <h2>{{$formando['nome']}} {{$formando['sobrenome']}}<small></small></h2>
                                    <p>{{ $contrato['name'] }} - {{ $contrato['institution'] }} - {{ $contrato['conclusion_year'] }}<br>
                                    {{ $formando['curso'] }} / {{ $formando['periodos'][$formando['periodo_id']] }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
            <!-- End Profile Header -->

            <!-- Profile -->
            <div class="row">
                <div class="col-xl-4">
                    <section class="panel profile-user" style="background-image: url({{asset('assets/common/img/temp/photos/12.jpg')}})">
                        <div class="panel-body">
                            <div class="profile-user-title text-center">
                                <div class="container" id="crop-avatar">
                                    <a class="avatar" href="javascript:void(0);" style="padding: 2px; !important;">
                                        <img src="{{ asset($formando['img']) }}?{{str_random(16)}}" alt="IMG Perfil" id="img_crop_perfil" class="avatar-view" style="border: none !important; margin: 0 !important;">
                                    </a>
                                    <div class="btn-group btn-group-justified" aria-label="" role="group" >

                                        <div class="btn-group hideOnMouseDiv">
                                            <button type="button" class="btn width-300 swal-btn-success avatar-view hideOnMouse">Alterar Foto</button>
                                        </div>

                                        <style>
                                            .hideOnMouse{
                                                visibility: hidden !important;
                                            }
                                            .hideOnMouseDiv:hover .hideOnMouse{
                                                visibility: visible !important;
                                            }
                                        </style>

                                        <!-- Cropping modal -->
                                        <div class="modal fade" id="avatar-modal" aria-hidden="true" aria-labelledby="avatar-modal-label" role="dialog" tabindex="-1" style="color: black !important;">
                                            <div class="modal-dialog modal-md">
                                                <div class="modal-content">
                                                    <form class="avatar-form" action="{{ asset('crop/avatar') }}" enctype="multipart/form-data" method="post">

                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                            <h4 class="modal-title" id="avatar-modal-label">Alterar Foto de Perfil</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="avatar-body">

                                                                <!-- Upload image and data -->
                                                                <div class="avatar-upload">
                                                                    <input type="hidden" class="avatar-src" name="avatar_src">
                                                                    <input type="hidden" class="avatar-data" name="avatar_data">
                                                                    <label for="avatarInput">Selecionar Foto</label>
                                                                    <input type="file" class="avatar-input" id="avatarInput" name="avatar_file">
                                                                </div>

                                                                <!-- Crop and preview -->
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <div class="avatar-wrapper"></div>
                                                                    </div>
                                                                    <!--
                                                                    <div class="col-md-3">
                                                                        <div class="avatar-preview preview-lg"></div>
                                                                        <div class="avatar-preview preview-md"></div>
                                                                        <div class="avatar-preview preview-sm"></div>
                                                                    </div>
                                                                    -->
                                                                </div>

                                                                <div class="row avatar-btns">
                                                                    <div class="col-md-12">
                                                                        <button type="submit" class="btn btn-primary btn-block avatar-save">Salvar</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- <div class="modal-footer">
                                                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                        </div> -->
                                                    </form>
                                                </div>
                                            </div>
                                        </div><!-- /.modal -->

                                        <!-- Loading state -->
                                        <div class="loading" aria-label="Loading" role="img" tabindex="-1"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <section class="panel">
                        <div class="panel-body">
                            <!--
                            <div class="profile-user-skills">
                                <h6>Produtos e Serviços</h6>
                                <span>Formatura Completa com 10 convites e 1 Mesa</span>
                                <progress class="progress progress-primary" value="74" max="100">74%</progress>
                                <span>Album de Formatura com Pen Drive e DVD</span>
                                <progress class="progress progress-primary" value="82" max="100">82%</progress>
                            </div>
                            -->
                        </div>
                    </section>
                    <!--
                    <section class="panel">
                        <div class="panel-body">
                            <h6>Information</h6>
                            <dl class="dl-horizontal user-profile-dl">
                                <dt>Courses End</dt>
                                <dd>Digital Ocean, Nokia</dd>
                                <dt>Address</dt>
                                <dd>New York, US</dd>
                                <dt>Skills</dt>
                                <dd><span class="label label-default">html</span> <span class="label label-default">css</span> <span class="label label-default">design</span> <span class="label label-default">javascript</span></dd>
                                <dt>Last companies</dt>
                                <dd>Microsoft, Soft Mailstorm</dd>
                                <dt>Personal Information</dt>
                                <dd>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</dd>
                            </dl>
                        </div>
                    </section>
                    -->
                </div>

                <div class="col-xl-8">
                    <section class="panel profile-user-content">
                        <div class="panel-body">
                            <div class="nav-tabs-horizontal">
                                <ul class="nav nav-tabs" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link" href="javascript: void(0);" data-toggle="tab" data-target="#dadospessoais" role="tab">
                                            <i class="fa fa-user"></i>
                                            Dados Pessoais
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="javascript: void(0);" data-toggle="tab" data-target="#endereco" role="tab">
                                            <i class="fa fa-map-pin"></i>
                                            Endereço
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="javascript: void(0);" data-toggle="tab" data-target="#dadoscontato" role="tab">
                                            <i class="fa fa-book"></i>
                                            Dados de Contato
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="javascript: void(0);" data-toggle="tab" data-target="#dadoscomplementares" role="tab">
                                            <i class="fa fa-bookmark-o"></i>
                                            Dados Complementares
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="javascript: void(0);" data-toggle="tab" data-target="#alterarsenha" role="tab">
                                            <i class="fa fa-lock"></i>
                                            Alterar senha
                                        </a>
                                    </li>
                                </ul>
                                {!! Form::model(\App\Forming::find($formando['id']), ['route' => ['portal.formando.update', $formando['id']]]) !!}
                                <div class="tab-content padding-vertical-20">
                                    @if ($errors->any())
                                        <div class="alert alert-danger">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                    <div class="tab-pane active" id="dadospessoais" role="tabpanel">

                                        <div class="col-lg-12">
                                            <!-- Example State Done -->
                                            <div class="step-block step-squared step-default" style="padding-bottom: 5px; padding-top: 5px;">
                                        <span class="step-digit">
                                            <i class="fa fa-user"><!-- --></i>
                                        </span>
                                                <div class="step-desc">
                                                    <span class="step-title">Dados Pessoais</span>
                                                    <p>Dados útilizados na sua adesão</p>
                                                </div>
                                            </div>
                                            <!-- End Example State Done -->
                                        </div>


                                        <div class="col-lg-12 margin-top-10"></div>


                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                {{ Form::label('nome', 'Nome') }}
                                                {{ Form::text('nome', null, array_merge(['class' => 'form-control'])) }}
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                {{ Form::label('sobrenome', 'Sobrenome') }}
                                                {{ Form::text('sobrenome', null, array_merge(['class' => 'form-control'])) }}
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group" id="alertValidCpf">
                                                {{ Form::label('cpf', 'CPF', array_merge(['id' => 'cpfLabel'])) }}
                                                {{ Form::text('cpf', null, array_merge(['class' => 'form-control', 'id' => 'cpf', 'disabled' => true])) }}
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                {{ Form::label('sexo', 'Sexo') }}
                                                {{ Form::select('sexo', ['' => 'Selecione...', 'M' => 'Masculino', 'F'=> 'Feminino'], null, array_merge(['class' => 'form-control', 'id' => 'cpf'])) }}
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                {{ Form::label('data-nascimento', 'Data de Nascimento') }}
                                                {{ Form::date('date_nascimento', null, array_merge(['class' => 'form-control', 'id' => 'datanascimento'])) }}
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                {{ Form::label('rg', 'RG') }}
                                                {{ Form::text('rg', null, array_merge(['class' => 'form-control'])) }}
                                            </div>
                                        </div>

                                    </div>
                                    <div class="tab-pane" id="endereco" role="tabpanel">

                                        <div class="col-lg-12">
                                            <!-- Example State Done -->
                                            <div class="step-block step-squared step-default" style="padding-bottom: 5px; padding-top: 5px;">
                                        <span class="step-digit">
                                            <i class="fa fa-map-pin"><!-- --></i>
                                        </span>
                                                <div class="step-desc">
                                                    <span class="step-title">Endereço</span>
                                                    <p>Dados de seu endereço</p>
                                                </div>
                                            </div>
                                            <!-- End Example State Done -->
                                        </div>

                                        <div class="col-lg-12 margin-top-10"></div>

                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                {{ Form::label('cep', 'CEP') }}
                                                {{ Form::text('cep', null, array_merge(['class' => 'form-control', 'id' => 'cep'])) }}
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                {{ Form::label('logradouro', 'Endereço') }}
                                                {{ Form::text('logradouro', null, array_merge(['class' => 'form-control', 'id' => 'logradouro'])) }}
                                            </div>
                                        </div>

                                        <div class="col-lg-1">
                                            <div class="form-group">
                                                {{ Form::label('numero', 'Número') }}
                                                {{ Form::text('numero', null, array_merge(['class' => 'form-control', 'id' => 'numero'])) }}
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                {{ Form::label('complemento', 'Complemento') }}
                                                {{ Form::text('complemento', null, array_merge(['class' => 'form-control', 'id' => 'complemento'])) }}
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                {{ Form::label('bairro', 'Bairro') }}
                                                {{ Form::text('bairro', null, array_merge(['class' => 'form-control', 'id' => 'bairro'])) }}
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                {{ Form::label('cidade', 'Cidade') }}
                                                {{ Form::text('cidade', null, array_merge(['class' => 'form-control', 'id' => 'cidade'])) }}
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                {{ Form::label('estado', 'Estado') }}
                                                {{ Form::text('estado', null, array_merge(['class' => 'form-control', 'id' => 'estado','maxlength' => '2'])) }}
                                            </div>
                                        </div>

                                    </div>
                                    <div class="tab-pane" id="dadoscontato" role="tabpanel">

                                        <div class="col-lg-12">
                                            <!-- Example State Done -->
                                            <div class="step-block step-squared step-default" style="padding-bottom: 5px; padding-top: 5px;">
                                        <span class="step-digit">
                                            <i class="fa fa-book"><!-- --></i>
                                        </span>
                                                <div class="step-desc">
                                                    <span class="step-title">Dados de Contato</span>
                                                    <p>Dados dos seus meios de contato</p>
                                                </div>
                                            </div>
                                            <!-- End Example State Done -->
                                        </div>

                                        <div class="col-lg-12 margin-top-10"></div>

                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                {{ Form::label('email', 'E-mail') }}
                                                {{ Form::email('email', null, array_merge(['class' => 'form-control', 'id' => 'email', 'disabled' => true])) }}
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                {{ Form::label('telefone-residencial', 'Telefone Residencial') }}
                                                {{ Form::text('telefone_residencial', null, array_merge(['class' => 'form-control', 'id' => 'telefone-residencial'])) }}
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                {{ Form::label('telefone-celular', 'Telefone Celular') }}
                                                {{ Form::text('telefone_celular', null, array_merge(['class' => 'form-control', 'id' => 'telefone-celular'])) }}
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                {{ Form::label('nome_do_pai', 'Nome do Pai') }}
                                                {{ Form::text('nome_do_pai', null, array_merge(['class' => 'form-control', 'id' => 'nome_do_pai'])) }}
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                {{ Form::label('email_do_pai', 'E-mail do Pai') }}
                                                {{ Form::email('email_do_pai', null, array_merge(['class' => 'form-control', 'id' => 'email_do_pai'])) }}
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                {{ Form::label('telefone_celular_pai', 'Telefone Celular do Pai') }}
                                                {{ Form::text('telefone_celular_pai', null, array_merge(['class' => 'form-control', 'id' => 'telefone_celular_pai'])) }}
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                {{ Form::label('nome_da_mae', 'Nome da Mãe') }}
                                                {{ Form::text('nome_da_mae', null, array_merge(['class' => 'form-control', 'id' => 'nome_da_mae'])) }}
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                {{ Form::label('email_da_mae', 'E-mail da Mãe') }}
                                                {{ Form::email('email_da_mae', null, array_merge(['class' => 'form-control', 'id' => 'email_da_mae'])) }}
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                {{ Form::label('telefone_celular_mae', 'Telefone Celular da Mãe') }}
                                                {{ Form::text('telefone_celular_mae', null, array_merge(['class' => 'form-control', 'id' => 'telefone_celular_mae'])) }}
                                            </div>
                                        </div>


                                    </div>
                                    <div class="tab-pane" id="dadoscomplementares" role="tabpanel">

                                        <div class="col-lg-12">
                                            <!-- Example State Done -->
                                            <div class="step-block step-squared step-default" style="padding-bottom: 5px; padding-top: 5px;">
                                        <span class="step-digit">
                                            <i class="fa fa-bookmark-o"><!-- --></i>
                                        </span>
                                                <div class="step-desc">
                                                    <span class="step-title">Dados Complementares</span>
                                                    <p>Dados blablablabalabla</p>
                                                </div>
                                            </div>
                                            <!-- End Example State Done -->
                                        </div>

                                        <div class="col-lg-12 margin-top-10"></div>

                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                {{ Form::label('altura', 'Altura') }}
                                                {{ Form::select('altura', $i_altura, null, array_merge(['class' => 'form-control', 'id' => 'altura'])) }}
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                {{ Form::label('camiseta', 'Camiseta') }}
                                                {{ Form::select('camiseta', $camiseta, null, array_merge(['class' => 'form-control', 'id' => 'camiseta'])) }}
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                {{ Form::label('calcado', 'Calçado') }}
                                                {{ Form::select('calcado', $calcado, null, array_merge(['class' => 'form-control', 'id' => 'calcado'])) }}
                                            </div>
                                        </div>

                                    </div>
                                    <div class="tab-pane" id="alterarsenha" role="tabpanel">

                                        <div class="col-lg-12">
                                            <!-- Example State Done -->
                                            <div class="step-block step-squared step-default" style="padding-bottom: 5px; padding-top: 5px;">
                                        <span class="step-digit">
                                            <i class="fa fa-lock"><!-- --></i>
                                        </span>
                                                <div class="step-desc">
                                                    <span class="step-title">Alterar Senha</span>
                                                    <p>Digite a nova senha abaixo, caso deseje alterar</p>
                                                </div>
                                            </div>
                                            <!-- End Example State Done -->
                                        </div>

                                        <div class="col-lg-12 margin-top-10"></div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                {{ Form::label('senha', 'Senha') }}
                                                {{ Form::password('password', ['class' => 'form-control']) }}
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                {{ Form::label('Confirme a Senha', 'Confirme a Senha') }}
                                                {{ Form::password('password_confirmation', ['class' => 'form-control']) }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <hr>
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-success btn-block">Salvar</button>
                                </div>
                                <div class="clearfix"></div>
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </section>
                </div>
            </div>
            <!-- End Profile -->

        </div>

    </section>


    <!-- Cropping modal -->
    <div class="modal fade" id="avatar-modal" aria-hidden="true" aria-labelledby="avatar-modal-label" role="dialog" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form class="avatar-form" action="{{env('APP_URL')}}/crop/avatar" enctype="multipart/form-data"
                      method="post">
                    <input type="hidden" name="_token" value="V2tu4scg7As6Gp676psb1vM5Tfzqsb1Z6GDu8TcY">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title" id="avatar-modal-label">Seleciona a imagem</h4>
                    </div>
                    <div class="modal-body">
                        <div class="avatar-body">

                            <!-- Upload image and data -->
                            <div class="avatar-upload form-group">
                                <input type="hidden" class="avatar-src" name="avatar_src">
                                <input type="hidden" class="avatar-data" name="avatar_data">
                                <label for="avatarInput">Buscar:</label>
                                <input type="file" class="avatar-input file" id="avatarInput" name="avatar_file">
                            </div>

                            <!-- Crop and preview -->
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="avatar-wrapper"></div>
                                </div>
                                <div class="col-md-3">
                                    <div class="avatar-preview preview-lg"></div>
                                    <div class="avatar-preview preview-md"></div>
                                    <div class="avatar-preview preview-sm"></div>
                                </div>
                            </div>

                            <div class="row avatar-btns">
                                <div class="col-md-9">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-primary" data-method="rotate"
                                                data-option="-90" title="Rotate -90 degrees">Girar Esq.
                                        </button>
                                        <button type="button" class="btn btn-primary" data-method="rotate"
                                                data-option="-15">-15deg
                                        </button>
                                        <button type="button" class="btn btn-primary" data-method="rotate"
                                                data-option="-30">-30deg
                                        </button>
                                        <button type="button" class="btn btn-primary" data-method="rotate"
                                                data-option="-45">-45deg
                                        </button>
                                    </div>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-primary" data-method="rotate"
                                                data-option="45">45deg
                                        </button>
                                        <button type="button" class="btn btn-primary" data-method="rotate"
                                                data-option="30">30deg
                                        </button>
                                        <button type="button" class="btn btn-primary" data-method="rotate"
                                                data-option="15">15deg
                                        </button>
                                        <button type="button" class="btn btn-primary" data-method="rotate"
                                                data-option="90" title="Rotate 90 degrees">Girar Dir.
                                        </button>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <button type="submit" class="btn btn-primary btn-block avatar-save">Salvar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div> -->
                </form>
            </div>
        </div>
    </div><!-- /.modal -->

    @if(Session::has('msg'))
        <script>
            $.notify("{{Session::get('msg')}}", {
                animate: {
                    enter: 'animated zoomInDown',
                    exit: 'animated zoomOutUp'
                },
                type: "success",
                delay: 5000,
                timer: 1000,
            });
        </script>
    @endif

@endsection