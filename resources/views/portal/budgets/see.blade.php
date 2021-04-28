@extends('portal.inc.layout')

@section('content')


<section class="page-content">
    <div class="page-content-inner">

     


        <section class="panel">
 
                <div class='col-lg-12'>
                    @if($objeto->pathfile)
                    <object width="100%" height="800" data="<?= url('/storage/uploads/orcamentos/'); ?>/<?= $objeto->pathfile; ?>"></object>
                    @endif
                </div>

           
        </section>



    </div>
</section>

@endsection