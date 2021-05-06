@extends('portal.inc.layout')

@section('content')

    <section class="page-content">
        <div class="page-content-inner">

            <a href="https://pni.affinibox.com.br/" target="_blank"><img src="{{ asset('img/portal/mmvantagem.jpg') }}" style="width: 100%" class="hover"></a>
            <a href="https://pni.affinibox.com.br/" target="_blank" style="display: none"><img src="{{ asset('img/portal/mmvantagem_hover.jpg') }}" style="width: 100%" class="hover"></a>

        </div>
    </section>

@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function(){
            $('.hover').hover(
                function() {
                    $( this ).attr('src', '{{ asset('img/portal/mmvantagem_hover.jpg') }}');
                }, function() {
                    $( this ).attr('src', '{{ asset('img/portal/mmvantagem.jpg') }}');
                }
            );
        });
    </script>


@endsection
