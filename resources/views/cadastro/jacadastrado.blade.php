@extends('layouts.app')

@section('content')
    <section class="page-content">
        <div class="page-content-inner" style="background-image: url(../assets/common/img/temp/login/4.jpg)">

            <!-- Login Page -->
            <div class="single-page-block-header">
                <div class="row">
                    <div class="col-lg-4 col-md-12 text-center">
                        <div>
                            <img src="../assets/common/img/logo.png" alt="{{env('APP_NAME')}}" style="height: 50px;" />
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

                            Você já efetuou seu cadastro, Obrigado!
                        </h3>
                        <a href="{!! route('cad.contrato', ['codturma' => $contract_id]) !!}" class="btn btn-primary btn-block">NOVO CADASTRO</a>
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
