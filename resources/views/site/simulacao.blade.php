@extends('layouts.app')

@section('content')
    <section class="page-content">
        <div class="page-content-inner" style="background-image: url(../site_assets/images/bg-1.jpg)">

            <!-- Login Page -->
            <div class="single-page-block-header" style="padding: 10px !important;">
                <div class="row">
                    <div class="col-lg-4 col-md-12 text-center">
                        <div>
                            <img src="../assets/common/img/logo.png" alt="SIFORME" style="height: 50px;" />
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <!--
                        <div class="single-page-block-header-menu">
                            <ul class="list-unstyled list-inline">
                                <li><a href="javascript: history.back();">&larr; Back</a></li>
                                <li class="active"><a href="javascript: void(0);">Login</a></li>
                                <li><a href="javascript: void(0);">About</a></li>
                                <li><a href="javascript: void(0);">Support</a></li>
                            </ul>
                        </div>
                        -->
                    </div>
                </div>
            </div>
            <div class="single-page-block">
                <div class="single-page-block-inner effect-3d-element">
                    <div class="blur-placeholder"><!-- --></div>
                    <div class="single-page-block-form">
                        <h3 class="text-center" style="color: #ff7a01;">
                            <i class="icmn-enter margin-right-10"></i>
                            Solicite sua simulação
                        </h3>
                        <form id="form-validation" name="form-validation" method="POST">


                            @if (Session::has('msg-error') > 0)
                                <div class="alert alert-danger">
                                    <ul>
                                            <li>{{ Session::get('msg-error') }}</li>
                                    </ul>
                                </div>
                            @endif
                                @if (Session::has('msg-ok') > 0)
                                    <div class="alert alert-success">
                                        <ul>
                                            <li>{{ Session::get('msg-ok') }}</li>
                                        </ul>
                                    </div>
                                @endif
                            {{ csrf_field() }}

                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">

                                    <input id="name" placeholder="Nome completo" name="name" type="text" class="form-control" value="{{ old('name') }}" required>

                                    @if ($errors->has('name'))
                                        <span class="help-block" style="color: red;">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">

                                    <input id="email" placeholder="Email" name="email" data-validation="[EMAIL]" type="text" class="form-control" value="{{ old('email') }}" required>

                                    @if ($errors->has('email'))
                                        <span class="help-block" style="color: red;">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="form-group{{ $errors->has('cellphone') ? ' has-error' : '' }}">

                                    <input id="cellphone" placeholder="Celular" name="cellphone" type="text" class="form-control" name="cellphone" value="{{ old('cellphone') }}" required>

                                    @if ($errors->has('cellphone'))
                                        <span class="help-block" style="color: red;">
                                        <strong>{{ $errors->first('cellphone') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="form-group{{ $errors->has('institution') ? ' has-error' : '' }}">

                                    <input id="institution" placeholder="Instituição" name="institution" type="text" class="form-control" value="{{ old('institution') }}" required>

                                    @if ($errors->has('institution'))
                                        <span class="help-block" style="color: red;">
                                        <strong>{{ $errors->first('institution') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="form-group{{ $errors->has('course') ? ' has-error' : '' }}">

                                    <input id="course" placeholder="Curso" name="course" type="text" class="form-control" value="{{ old('course') }}" required>

                                    @if ($errors->has('course'))
                                        <span class="help-block" style="color: red;">
                                        <strong>{{ $errors->first('course') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <select class="form-control" id="commission" name="commission" required>
                                        <option value="" disabled selected>Você é mebro da comissão de formatura?</option>
                                        <option value="Sim">Sim</option>
                                        <option value="Não">Não</option>
                                        <option value="Não, mas conheço!">Não, mas conheço!</option>
                                    </select>
                                </div>

                                <div class="form-actions">
                                    <button type="submit" class="btn btn-primary btn-block">
                                        CADASTRAR
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!--
            <div class="single-page-block-footer text-center">
                <ul class="list-unstyled list-inline">
                    <li><a href="javascript: void(0);">Terms of Use</a></li>
                    <li class="active"><a href="javascript: void(0);">Compliance</a></li>
                    <li><a href="javascript: void(0);">Confidential Information</a></li>
                    <li><a href="javascript: void(0);">Support</a></li>
                    <li><a href="javascript: void(0);">Contacts</a></li>
                </ul>
            </div>
            <!-- End Login Page -->
            -->

        </div>

        <!-- Page Scripts -->
        <script>
            $(function() {

                $('#cellphone').mask("(00) 00000-0000");
                $('#cpf').mask("000.000.000-00");

                // Add class to body for change layout settings
                $('body').addClass('single-page single-page-inverse');

                // Set Background Image for Form Block
                function setImage() {
                    var imgUrl = $('.page-content-inner').css('background-image');

                    $('.blur-placeholder').css('background-image', imgUrl);
                };

                function changeImgPositon() {
                    var width = $(window).width(),
                        height = $(window).height(),
                        left = - (width - $('.single-page-block-inner').outerWidth()) / 2,
                        top = - (height - $('.single-page-block-inner').outerHeight()) / 2;


                    $('.blur-placeholder').css({
                        width: width,
                        height: height,
                        left: left,
                        top: top
                    });
                };

                setImage();
                changeImgPositon();

                $(window).on('resize', function(){
                    changeImgPositon();
                });

                // Mouse Move 3d Effect
                var rotation = function(e){
                    var perX = (e.clientX/$(window).width())-0.5;
                    var perY = (e.clientY/$(window).height())-0.5;
                    TweenMax.to(".effect-3d-element", 0.4, { rotationY:15*perX, rotationX:15*perY,  ease:Linear.easeNone, transformPerspective:1000, transformOrigin:"center" })
                };

                if (!cleanUI.hasTouch) {
                    $('body').mousemove(rotation);
                }

            });
        </script>
        <!-- End Page Scripts -->
    </section>

    <div class="main-backdrop"><!-- --></div>
@endsection
