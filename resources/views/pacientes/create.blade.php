@extends('layouts.app')

@section('title', 'Crear Paciente')


@section('main-content')

  @if (count($errors) > 0)
      <div class="alert alert-danger">
          <ul>
              @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
              @endforeach
          </ul>
      </div> 
  @endif

    {!!Form::open(['route'=>'pacientes.store', 'method' =>'POST', 'id'=>'pacientes_create' ,'name'=>'pacientes_create'])!!}
<div class="box box-primary">
  <div class="box-header">
    <h2> Ficha Dental</h2>
  </div>
  <div class ="box-body">
      <div class="col-lg-6">
        {!!Form::label('pac_nombres', 'Nombres Paciente')!!}
        {!!Form::text('pac_nombres', null, ['class'=>'form-control'])!!}
      </div>

      <div class="col-lg-6">
        {!!Form::label('pac_apellido_paterno', 'Apellido Paterno')!!}
        {!!Form::text('pac_apellido_paterno', null, ['class'=>'form-control'])!!}
      </div>

      <div class="col-lg-6">
        {!!Form::label('pac_apellido_materno', 'Apellido Materno')!!}
        {!!Form::text('pac_apellido_materno', null, ['class'=>'form-control'])!!}
      </div>

      <div class="col-lg-6">
        {!!Form::label('pac_rut_completo', 'Rut Paciente')!!}
        {!!Form::text('pac_rut_completo', null, ['class'=>'form-control','id'=>'rut'])!!}
      </div> 

      <div class="col-lg-6">
        {!!Form::label('pac_edad', 'Edad')!!}
        {!!Form::number('pac_edad', null, ['class'=>'form-control'])!!}
      </div>

      <div class="col-lg-6">
        {!!Form::label('pac_direccion', 'Direccion')!!}
        {!!Form::text('pac_direccion', null, ['class'=>'form-control'])!!}
      </div>

      <div class=" col-lg-6">
        {!!Form::label('pac_telefono', 'Teléfono')!!}
        {!!Form::text('pac_telefono', null, ['class'=>'form-control'])!!}
      </div>

      <div class="col-lg-12">
        {!!Form::label('pac_motivo', 'Motivo')!!}
        {!!Form::textarea('pac_motivo', null, ['class'=>'form-control', 'rows' => 4])!!}
      </div>
    </div>
</div>

<div class="box box-primary">
  <div class="box-header">
    <h2> Antecedentes Medicos Generales (Anamnesis)
    <button id="remove-all" name ="remove-all" class="btn btn-warning pull-right" type="button" title ="Borrar Todos los Antecedentes"><i class="fa fa-minus-circle" aria-hidden="true"></i></button></h2>
  </div>
  <div class="box-body" id="antecedentes">
      <div id = 'tipos'>
      <div class="col-lg-4">
        {!! Form::Label('tipos', 'Tipos:') !!}
        {!! Form::select('tan_id[]', $tipos, null, ['class' => 'form-control', 'placeholder'=> 'Seleccione Un Tipo', 'id ' => 'tan_id']) !!}
      </div>
      <div class="col-lg-7">
        {!!Form::label('amg_descripcion', 'Descripcion:')!!}
        {!!Form::text('amg_descripcion[]', null, ['class'=>'form-control'])!!}
      </div>
      
      <button id="add" name="add" class="btn btn-success pull-right " type="button" title ="Añadir otro Tipo"><i class="fa fa-plus" aria-hidden="true"></i></button>
     
      </div>

      
    </div>
</div>


<div class="box box-primary">
  <div class="box-header with-border">
    <h2> Examen Intraoral</h2>
  </div>
  <div class="box-body">
     <div class="col-lg-12">
        {!!Form::label('pac_observaciones', 'Observaciones')!!}
        {!!Form::textarea('pac_observaciones', null, ['class'=>'form-control', 'rows' => 4])!!}
      </div> 
    </div>
      <div class ="box-footer with-border">
        <div class="form-horizontal" align="center">
          {!!Form::submit('Crear Paciente',['class'=>'btn btn-success', 'id' => 'crear'])!!}
        </div>
      </div>
</div>

<script type="text/javascript">


  $(function(){
      $("#rut").rut();
  }
  );
</script>



<!--js del formulario dinamico-->
<script type="text/javascript">
  
  $(document).ready(function(){
    var i = 1;
    $(document).on('click', '#add', function(){
     
      var html = '';

      html += '<div class ="col-lg-4"> {!! Form::select('tan_id[]', $tipos, null, ['class' => 'form-control', 'placeholder'=> 'Seleccione Un Tipo', 'id' => 'tan_id']) !!}  </div>';
      html += '<div class="col-lg-7"> {!!Form::text('amg_descripcion[]', null, ['class'=>'form-control'])!!} </div>';
      html += '<button id="remove" name="remove" class="btn btn-danger pull-right" type="button" title ="Remover Antecedente"><i class="fa fa-minus" aria-hidden="true"></i></button> ';

      
      if (i <= 3) {
        $('#tipos').append(html);
        i++;
       

        }

    });

    $(document).on('click', '#remove', function(){
        i--;
        $(this).prev('div').remove();
        $(this).prev('div').remove();
        $(this).remove();
        
    });
//restablecer formulario por defecto
   $(document).on('click', '#remove-all', function(){
      i = 1;
      //vaciar todos los elementos del box especialidades
      $('#antecedentes').empty();
      //añadir los elementos de un especialidad nuevamente
      var html_all = '';
      html_all += '<div id = "tipos">';
      html_all +='<div class ="col-lg-4">';
      html_all +='{!! Form::Label('tipos', 'Tipos:') !!}';
      html_all +='{!! Form::select('tan_id[]', $tipos, null, ['class' => 'form-control', 'placeholder'=> 'Seleccione Un Tipo']) !!} </div>';
      html_all += '<button id="add" name="add" class="btn btn-success pull-right " type="button" title ="Añadir otro Tipo"><i class="fa fa-plus" aria-hidden="true"></i></button> ';
      html_all += '<div class="col-lg-7">';
      html_all += '{!!Form::label('amg_descripcion', 'Descripcion:')!!} {!!Form::text('amg_descripcion[]', null, ['class'=>'form-control'])!!}';
      html_all += '</div> </div>';


      $('#antecedentes').append(html_all);

    });
  });


//funcion para verificar que los antecedentes tengan distinto tipo
  $(document).on('click', '#crear', function(){
      
  var selects = document.getElementsByTagName("select"),
      i,
      current,
      selected = {};
  for(i = 0; i < selects.length; i++){
    current = selects[i].selectedIndex;
    if (selected[current]) {
      alert("Debe seleccionar un solo tipo por Antecedente");
      return false;
    } else
      selected[current] = true;
  }
 
  return true;

      
  });


</script>


{!!Form::close()!!}



@endsection
