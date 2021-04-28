@extends('gerencial.inc.layout')

@section('content')

    <section class="page-content">
        <div class="page-content-inner">
            
         
         <div class="row">
             <div class="col-sm-12">

                <h5>Cadastrar cursos</h5>

                @if($errors->any())
                <h4>{{$errors->first()}}</h4>
                @endif

                {!! Form::open(['route'=>'gerencial.cursos.store']) !!}
                
                    <div class="form-group">
                        {!! Form::label('Nome do curso') !!}
                        {!! Form::text('nome', '', ['class' => 'form-control','required']) !!}
    
                    </div>
                    

                    {!! Form::submit('enviar', ['class'=>'btn btn-success']) !!}

                {!! Form::close() !!}
             </div>
         </div>
         <hr>
         <h5>Cursos cadastrados</h5>
         <div class="row">
             <div class="col-sm-12">
                <table class="table" id="cursos">
                    <thead class="thead-inverse">
                        <tr>
                            <th>Id</th>
                            <th>Curso</th>
                            <th>Excluir</th>
                            <th>Editar</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($cursos as $item)
                            <tr>
                                <td scope="row">{{$item->id}}</td>
                                <td>{{$item->name}}</td>
                                {!! Form::open(['route'=>['gerencial.cursos.delete',$item->id],'id'=>'formDelete']) !!}
                                <td><a onclick="deleteConfirm()"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
                                {!! Form::close() !!}
                                <td><a href="#" id="editar"><i class="fa fa-edit" aria-hidden="true"></i></a></td>
                            </tr> 
                            @endforeach
                            
                        </tbody>
                </table>
            </div>
         </div>
         
        </div>
    </section>
@endsection


@section('script')

<script>

$(document).ready(function() {
 
    $('#cursos').DataTable({
        language: {
          "url":"http://cdn.datatables.net/plug-ins/1.10.21/i18n/Portuguese-Brasil.json" ,                   
          }
     }); 
});

function deleteConfirm(){

swal({
  title: "Tem certeza de que deseja apagar?",
  text: "Essa operação não pode ser desfeita",
  type: "warning",
  showCancelButton: true,
  confirmButtonColor: "#DD6B55",
  confirmButtonText: "Sim!",
  cancelButtonText: "Não, cancelar!",
  closeOnConfirm: false,
  closeOnCancel: false
},
function(isConfirm){
  if (isConfirm) {
    $('#formDelete').submit();          
  } else {
    // swal("Cancelado", "Seu registro não foi apagado :)", "error");
    console.log('teste');
  }
  swal.close();
});

}





</script>

@endsection
