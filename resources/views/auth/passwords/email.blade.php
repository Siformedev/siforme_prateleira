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
                            Recuperar a Senha
                        </h3>
                        <br />
                        <form id="form-validation" name="form-validation" role="form" action="{{ route('password.email') }}" method="POST">
                            {{ csrf_field() }}

                            @if (session('status'))
                                <div class="alert alert-success">
                                    {{ session('status') }}
                                </div>
                            @endif

                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label for="email" class="col-md-12 control-label">Digite abaixo seu email de cadastrado</label>

                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                                <hr>
                                <button type="submit" class="btn btn-primary btn-block">
                                    Enviar link de recuperação
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
   <!--
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Reset Password</div>
                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form class="form-horizontal" role="form" method="POST" action="{{ route('password.email') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Send Password Reset Link
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
-->
@endsection
