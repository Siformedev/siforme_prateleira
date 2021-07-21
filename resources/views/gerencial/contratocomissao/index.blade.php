@extends('gerencial.inc.layout')
@section('content')
<section class="page-content">
    <div class="page-content-inner">
        <!--  -->
        <section class="panel">
            <div class="panel-heading">
                <div class="col-md-10">
                    <h3>Contrato Comissão</h3>
                </div>
                <div class="col-md-2">
                    <a href="{{route('gerencial.contratocomissao.create',["id"=>0,"contract"=>$contract])}}" class="btn btn-success btn-block"><i class="icmn icmn-plus"></i> Novo</a>
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
                                    <th>Link Pdf</th>
                                    <th>Ação</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($budgets as $contratocomissao)
                                <tr>
                                    <td>
                                        <span class="font-size-16 font-weight-bold">{{$contratocomissao->id}}</span></td>
                                    <td>{{$contratocomissao->linkpdf}}</td>
                                    <td>
                                        <a href="{{route('gerencial.contratocomissao.create', ['id'=>$contratocomissao->id,'contract' => $contratocomissao->contract_id])}}" class="btn btn-info" data-toggle="tooltip" data-placement="top" title="Editar"><i class="icmn icmn-pencil7"></i> </a>
                                        <a href="{{route('gerencial.contratocomissao.delete', ['id'=>$contratocomissao->id])}}" class="btn btn-danger deletebutton" data-toggle="tooltip" data-placement="top" title="Editar"><i class="fa fa-remove"></i> </a>
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