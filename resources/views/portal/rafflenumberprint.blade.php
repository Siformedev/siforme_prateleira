@extends('portal.inc.layout_print')

@section('content')


        <div class="col-lg-12 col-md-12 col-sm-12">
            <img src="{{$url}}" style="width: 100%; max-width: 800px">

        </div>

        <script>
            print();
        </script>


@endsection