@extends('gerencial.inc.layout')
@section('content')
<section class="page-content">
    <div class="page-content-inner">
        <!--  -->
        <section class="panel">
            <div class="panel-heading">
                <div class="col-md-10">
                    <h3>Listagem de Brindes</h3>
                </div>
                <div class="col-md-2">
                    <a href="{{route('gerencial.brindes.create',["id"=>0,"contract"=>$contract])}}" class="btn btn-success btn-block"><i class="icmn icmn-plus"></i> Novo</a>
                </div>
                <hr>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-hover nowrap dataTable dtr-inline" id="table1">
                            <thead>
                                <tr>
                                    <th>Código</th>
                                    <th>Nome do Brinde</th>
                                    <th>Descrição do Brinde</th>
                                    <th></th>
                                    <th>Ação</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($budgets as $brindes)
                                <tr>
                                    <td>
                                        <span class="font-size-16 font-weight-bold">{{$brindes->id}}</span></td>
                                    <td>{{$brindes->nome}}</td>
                                    <td>{{$brindes->descricao}}</td>
                                    <td><img src="<?= url('/storage/uploads/brindes/'); ?>/<?= $brindes->pathfile; ?>" width="100"></td>
                                    <td>
                                        <a href="{{route('gerencial.brindes.create', ['id'=>$brindes->id,'contract' => $brindes->contract_id])}}" class="btn btn-info" data-toggle="tooltip" data-placement="top" title="Editar"><i class="icmn icmn-pencil7"></i> </a>
                                        <a href="{{route('gerencial.brindes.delete', ['id'=>$brindes->id])}}" class="btn btn-danger deletebutton" data-toggle="tooltip" data-placement="top" title="Editar"><i class="fa fa-remove"></i> </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>


        
        <!-- End  -->
    </div>
    <!-- Page Scripts -->
</section>
@endsection