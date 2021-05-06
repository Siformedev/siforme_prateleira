@extends('gerencial.inc.layout')
@section('content')
<section class="page-content">
    <div class="page-content-inner">
        <!--  -->
        <section class="panel">
            <div class="panel-heading">
                <div class="col-md-10">
                    <h3>Listagem de Orçamentos</h3>
                </div>
                <div class="col-md-2">
                    <a href="{{route('gerencial.budget.create',["id"=>0,"contract"=>$contract])}}" class="btn btn-success btn-block"><i class="icmn icmn-plus"></i> Novo</a>
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
                                @foreach($budgets as $budget)
                                <tr>
                                    <td>
                                        <span class="font-size-16 font-weight-bold">{{$budget->id}}</span></td>
                                    <td>{{$budget->linkpdf}}</td>
                                    <td>
                                        <a href="{{route('gerencial.budget.create', ['id'=>$budget->id,'contract' => $budget->contract_id])}}" class="btn btn-info" data-toggle="tooltip" data-placement="top" title="Editar"><i class="icmn icmn-pencil7"></i> </a>
                                        <a href="{{route('gerencial.budget.delete', ['id'=>$budget->id])}}" class="btn btn-danger deletebutton" data-toggle="tooltip" data-placement="top" title="Editar"><i class="fa fa-remove"></i> </a>
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