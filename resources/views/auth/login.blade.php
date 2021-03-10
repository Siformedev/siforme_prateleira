@extends('layouts.app')

@section('content')
    <section class="page-content">
        <div class="page-content-inner" style="background-image: url(../assets/common/img/temp/login/4.jpg)">

            <!-- Login Page -->
            <div class="single-page-block-header">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="logo">
                            <img src="../assets/common/img/logo.png" alt="SIFORME" />
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
                            Portal do Formando
                        </h3>
                        <br />
                        <form id="form-validation" name="form-validation" method="POST">

                            @if (count($errors) > 0)
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            {{ csrf_field() }}

                            <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">

                                    <input id="validation-email" placeholder="Email" name="email" data-validation="[EMAIL]" type="text" class="form-control" name="username" value="{{ old('username') }}" required autofocus>

                                    @if ($errors->has('username'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('username') }}</strong>
                                    </span>
                                    @endif
                            </div>

                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                    <input id="password" type="password" class="form-control" name="password" placeholder="Senha" required>

                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                            </div>

                            <div class="form-group">
                                <a href="{{ route('password.request') }}" class="pull-right">Esqueceu sua senha?</a>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Lembrar acesso
                                    </label>
                                </div>
                            </div>


                            <div class="form-actions">
                                    <button type="submit" class="btn btn-primary width-150">
                                        Entrar
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

    <div class="main-backdrop"><!-- --></div>
@endsection
