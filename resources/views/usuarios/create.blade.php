@extends('layouts.app')

@section('title', 'Crear Usuario')


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

{!!Form::open(['route'=>'usuarios.store', 'method' =>'POST', 'id'=>'usuarios_create' ,'name'=>'usuarios_create'])!!}
<div class="box box-primary">
	<div class="box-header">
		<h2>Formulario de Creación de Usuario</h2>
		<h3>Identificación Básica</h3>
	</div>
	<div class="box-body">

		<div class="col-lg-6">
			{!!Form::label('usu_nombres', 'Nombres Usuario')!!}
			{!!Form::text('usu_nombres', null, ['class' => 'form-control'])!!}
		</div>

		<div class="col-lg-6">
			{!!Form::label('usu_apellido_paterno', 'Apellido Paterno')!!}
			{!!Form::text('usu_apellido_paterno', null, ['class' => 'form-control'])!!}
		</div>

		<div class="col-lg-6">
			{!!Form::label('usu_apellido_materno', 'Apellido Materno')!!}
			{!!Form::text('usu_apellido_materno', null, ['class' => 'form-control']) !!}	
		</div>

		<div class="col-lg-6">
			{!!Form::label('usu_rut_completo', 'Rut Usuario') !!}
			{!!Form::text('usu_rut_completo', null, ['class' => 'form-control', 'id' => 'rut']) !!}
		</div>

		<div class="col-lg-6">
			{!!Form::label('usu_direccion', 'Dirección')!!}
			{!!Form::text('usu_direccion', null, ['class' =>'form-control'])!!}
		</div>

		<div class="col-lg-6">
			{!!Form::label('com_id', 'Comuna de Residencia')!!}
			{!!Form::select('com_id', $comuna, null, ['class' => 'form-control', 'placeholder'=> 'Seleccione Comuna de Residencia', 'id ' => 'com_id'])!!}
		</div>

		<div class="col-lg-6">
			{!!Form::label('usu_email', 'Email Usuario') !!}
			{!!Form::text('usu_email', null, ['class'=> 'form-control']) !!}
		</div>

		<div class="col-lg-6">
			{!!Form::label('usu_telefono', 'Teléfono de Contacto')!!}
			{!!Form::number('usu_telefono', null, ['class'=> 'form-control'])!!}
		</div>

		
	</div>
</div>

<div class="box box-primary">
	<div class="box-header with-border">
		<h3>Información de Cuenta de Usuario</h3>
	</div>
	<div class="box-body">
		<div class="col-lg-6">
			{!!Form::label('usu_usuario', 'Nombre de Usuario')!!}
			{!!Form::text('usu_usuario', null, ['class' => 'form-control'])!!}
		</div>

		<div class="col-lg-6">
			{!!Form::label('usu_rol', 'Rol del Usuario')!!}
			{!!Form::select('usu_rol', ['Odontólogo'=>'Odontologo', 'Asistente' => 'Asistente', 'Administrador' => 'Administrador'], null, ['class' => 'form-control'])!!}
		</div>
	</div>
</div>

<div class = "box box-primary" >
    <div class = "box-header with-border"> 
      <h3>Especialidad(es) <i class='fa fa-question-circle' title ="Solo los Odontólogos y Administrador pueden tener Especialidad"></i><button id="remove-all" name ="remove-all" class="btn btn-warning pull-right" type="button" title ="Eliminar Todas las Especialidades"><i class="fa fa-minus-circle" aria-hidden="true"></i></button> </h3>
    </div>
    <div class = 'box-body' id="especialidades">
      <div class ="col-lg-7">
       {!! Form::Label('especialidades', 'Especialidad:') !!}
       {!! Form::select('esp_id[]', $especialidades, null , ['id' => 'esp_id[]', 'class' => 'form-control ' , 'placeholder' =>'Seleccione Especialidad']) !!}
        </div>
        <button id="add" name="add" class="btn btn-success pull-right " type="button" title= "Añadir nueva especialidad"><i class="fa fa-plus" aria-hidden="true"></i></button>
         
   </div>
   	<div class="box-footer">
   		{!!Form::submit('Crear Usuario',['class'=>'btn btn-success', 'id' => 'crear'])!!}
   	</div>
  </div>




<script type="text/javascript">
  
  $(document).ready(function(){
    var i = 1;
    $(document).on('click', '#add', function(){
      
      var html = '';
      html += '<div class ="col-lg-7"> {!!Form::select('esp_id[]', $especialidades, null, ['id' => 'esp_id[]', 'class' => 'form-control ' , 'placeholder' =>'Seleccione Especialidad'])!!}   </div>';
      html += '<button id="remove" name="remove" class="btn btn-danger pull-right" type="button" title = "Eliminar Especialidad"><i class="fa fa-minus" aria-hidden="true"></i></button> '; 
      
      if (i <= 3) {
        $('#especialidades').append(html);
        i++;

        }

    });

    $(document).on('click', '#remove', function(){
        i--;
        $(this).prev('div').remove();
        $(this).remove();
        
    });

   $(document).on('click', '#remove-all', function(){
      i=1;
      //vaciar todos los elementos del box especialidades
      $('#especialidades').empty();
      //añadir los elementos de un especialidad nuevamente
      var html_all = '';
      html_all +='<div class ="col-lg-7">';
      html_all +='{!! Form::Label('especialidades', 'Especialidad:') !!}';
      html_all +='{!! Form::select('esp_id[]', $especialidades, null , ['id' => 'esp_id[]', 'class' => 'form-control ' , 'placeholder' =>'Seleccione Especialidad']) !!} </div>';
      html_all += '<button id="add" name="add" class="btn btn-success pull-right " type="button" title= "Añadir nueva especialidad"><i class="fa fa-plus" aria-hidden="true"></i></button>';

      $('#especialidades').append(html_all);

    });
  });

  //funcion en la que tengo problema


  $(document).on('click', '#crear', function(){
      
  var selects = document.getElementById("esp_id[]"),
      i,
      current,
      selected = {};
      for(i = 0; i < selects.length; i++){
        current = selects.options[selects.selectedIndex].text;
        if (selected[current]) {

          alert("Debe seleccionar un solo tipo por Antecedente");
          return false;
        } else{
          selected[current] = true;
               }
      }
     
      return true;

      
  });

</script>




{!!Form::close()!!}
@endsection