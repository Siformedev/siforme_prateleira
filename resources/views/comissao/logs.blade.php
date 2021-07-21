@extends('comissao.inc.layout')
@section('content')
<section class="page-content">
    <div class="page-content-inner">
        <section class="panel">
            <div class="panel-heading">
                <h3>Registro de Logs</h3>
                <hr>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-hover nowrap dataTable dtr-inline" id="table1">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nome do Aluno</th>
                                    <th>Ação</th>
                                    <th>Criado Em</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($logs as $return)
                                <?php
                                $forming = $return->forming();
                                ?>
                                <tr>
                                    <td>
                                        <?= $return->id; ?>
                                    </td>
                                    <td>
                                        <?= $forming->nome . " " . $forming->sobrenome; ?>
                                    </td>
                                    <td>
                                        <?= $return->action; ?>
                                    </td>
                                    <td>
                                        <?= $helper->toMysqlDate($return->created_at, false); ?>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </div>
</section>
@section('jscripts')
comissao.datatable('#table1');
@endsection
@endsection