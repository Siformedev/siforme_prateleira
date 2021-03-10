@extends('portal.inc.layout')

@section('content')


    <section class="page-content">
        <div class="page-content-inner">

            <section class="panel">
                <div class="panel-heading">

                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <h1>Fotos</h1>
                        </div>
                    </div>
                </div>
            </section>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if(count($photos))

                @foreach($photos as $f)
                    <div class="col-lg-4 col-md-12">
                        <img src="{{asset($public . '/' . $f)}}" class="img-thumbnail">
                    </div>
                @endforeach
            @else

                <form action="{{route('portal.photos.upload')}}" method="post" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="col-md-12 col-lg-4">
                        <section class="panel" style="">
                            <div class="panel-heading">
                                <h3>
                                </h3>
                            </div>
                            <div class="panel-body">
                                <div class="row text-center">
                                    <div class="col-md-12">
                                <span style="font-size: 50px"><i class="icmn-images"
                                                                 style=""></i></span>

                                    </div>
                                    <div class="col-md-12">
                                        <span style="font-size: 20px;"> Foto Criança </span>
                                    </div>
                                    <div class="col-md-12" style="font-size: 16px;">
                                        <input type="file" name="foto_crianca" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                    <div class="col-md-12 col-lg-4">
                        <section class="panel" style="">
                            <div class="panel-heading">
                                <h3>
                                </h3>
                            </div>
                            <div class="panel-body">
                                <div class="row text-center">
                                    <div class="col-md-12">
                                <span style="font-size: 50px"><i class="icmn-images"
                                                                 style=""></i></span>

                                    </div>
                                    <div class="col-md-12">
                                        <span style="font-size: 20px;"> Foto Familia </span>
                                    </div>
                                    <div class="col-md-12" style="font-size: 16px;">
                                        <input type="file" name="foto_familia" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                    <div class="col-md-12 col-lg-4">
                        <section class="panel" style="">
                            <div class="panel-heading">
                                <h3>
                                </h3>
                            </div>
                            <div class="panel-body">
                                <div class="row text-center">
                                    <div class="col-md-12">
                                <span style="font-size: 50px"><i class="icmn-images"
                                                                 style=""></i></span>

                                    </div>
                                    <div class="col-md-12">
                                        <span style="font-size: 20px;"> Foto Livre </span>
                                    </div>
                                    <div class="col-md-12" style="font-size: 16px;">
                                        <input type="file" name="foto_livre" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                    <div class="col-md-12">
                        <input type="submit" class="btn btn-primary btn-block" value="Enviar">
                    </div>
                </form>
            @endif


        </div>
    </section>

@endsection