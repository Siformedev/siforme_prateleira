@extends('layouts.app')

@section('content')
    <section class="page-content">
        <div class="page-content-inner" style="background-image: url({{asset('assets/common/img/temp/login/4.jpg')}})">

            <!-- Login Page -->
            <div class="single-page-block-header">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="logo">
                            <img src="{{asset('assets/common/img/logo.png')}}" alt="{{env('APP_NAME')}}" />
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
                        <h3 class="text-center">
                            <i class="icmn-enter margin-right-10"></i>
                            Resetar Senha
                        </h3>
                        <br />
                        <form class="form-horizontal" role="form" method="POST" action="{{ route('password.request') }}">

                            @if (session('status'))
                                <div class="alert alert-success">
                                    {{ session('status') }}
                                </div>
                            @endif

                            {{ csrf_field() }}

                            <input type="hidden" name="token" value="{{ $token }}">

                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label for="email" class="col-md-12 control-label">Digite seu E-mail</label>

                                    <input id="email" type="email" class="form-control" name="email" value="{{ $email or old('email') }}" required autofocus>

                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                                    @endif
                            </div>

                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <label for="password" class="col-md-12 control-label">Nova Senha</label>

                                    <input id="password" type="password" class="form-control" name="password" required>

                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                                    @endif
                            </div>


                            <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                                <label for="password-confirm" class="col-md-12 control-label">Confirmar Nova Senha</label>
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>

                                    @if ($errors->has('password_confirmation'))
                                        <span class="help-block">
                                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                                </span>
                                    @endif
                            </div>
                            <hr>
                            <div class="form-group">
                                    <button type="submit" class="btn btn-success">
                                        Salvar nova senha
                                    </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="single-page-block-footer text-center">

            </div>
            <!-- End Login Page -->

        </div>

        <!-- Page Scripts -->
        <script>
            $(function() {

                // Form Validation
                $('#form-validation').validate({
                    submit: {
                        settings: {
                            inputContainer: '.form-group',
                            errorListClass: 'form-control-error',
                            errorClass: 'has-danger'
                        }
                    }
                });

                // Show/Hide Password
                $('.password').password({
                    eyeClass: '',
                    eyeOpenClass: 'icmn-eye',
                    eyeCloseClass: 'icmn-eye-blocked'
                });

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
@endsection
