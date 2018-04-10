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

{!!Form::open(['route'=>['usuarios.update', $usuario], 'method' =>'PUT', 'id'=>'usuarios_update' ,'name'=>'usuarios_update'])!!}
<div class="box box-primary">
	<div class="box-header">
		<h2>Formulario de Creación de Usuario</h2>
		<h3>Identificación Básica</h3>
	</div>
	<div class="box-body">

		<div class="col-lg-6">
			{!!Form::label('usu_nombres', 'Nombres Usuario')!!}
			{!!Form::text('usu_nombres', $usuario->usu_nombres, ['class' => 'form-control'])!!}
		</div>

		<div class="col-lg-6">
			{!!Form::label('usu_apellido_paterno', 'Apellido Paterno')!!}
			{!!Form::text('usu_apellido_paterno', $usuario->usu_apellido_paterno, ['class' => 'form-control'])!!}
		</div>

		<div class="col-lg-6">
			{!!Form::label('usu_apellido_materno', 'Apellido Materno')!!}
			{!!Form::text('usu_apellido_materno', $usuario->usu_apellido_materno, ['class' => 'form-control']) !!}	
		</div>

		<div class="col-lg-6">
			{!!Form::label('usu_rut_completo', 'Rut Usuario') !!}
			{!!Form::text('usu_rut_completo', $usuario->usu_rut_completo, ['class' => 'form-control', 'id' => 'rut']) !!}
		</div>

    <div class="col-lg-6">
      {!!Form::label('usu_fecha_nacimiento', 'Fecha de Nacimiento')!!}
      {!!Form::date('usu_fecha_nacimiento', $usuario->usu_fecha_nacimiento, ['class' =>'form-control'])!!}
    </div>

		<div class="col-lg-6">
			{!!Form::label('usu_direccion', 'Dirección')!!}
			{!!Form::text('usu_direccion', $usuario->usu_direccion, ['class' =>'form-control'])!!}
		</div>

		<div class="col-lg-6">
			{!!Form::label('com_id', 'Comuna de Residencia')!!}
			{!!Form::select('com_id', $comuna, $usuario->com_id, ['class' => 'form-control', 'placeholder'=> 'Seleccione Comuna de Residencia', 'id ' => 'com_id'])!!}
		</div>

		<div class="col-lg-6">
			{!!Form::label('usu_email', 'Email Usuario') !!}
			{!!Form::text('usu_email', $usuario->usu_email, ['class'=> 'form-control']) !!}
		</div>

		<div class="col-lg-6">
			{!!Form::label('usu_telefono', 'Teléfono de Contacto')!!}
			{!!Form::number('usu_telefono', $usuario->usu_telefono, ['class'=> 'form-control'])!!}
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
			{!!Form::text('usu_usuario', $usuario->usu_usuario, ['class' => 'form-control'])!!}
		</div>

		<div class="col-lg-6">
			{!!Form::label('usu_rol', 'Rol del Usuario')!!}
			{!!Form::select('usu_rol', ['Odontólogo'=>'Odontologo', 'Asistente' => 'Asistente', 'Administrador' => 'Administrador'], $usuario->usu_rol, ['class' => 'form-control'])!!}
		</div>

    <div class="col-lg-6">
      {!!Form::label('usu_password', 'Contraseña')!!}
      {!!Form::password('usu_password', ['class' => 'form-control'])!!}
    </div>

    <div class="col-lg-6">
      {!!Form::label('usu_confirmar_password', 'Confirmar Contraseña')!!}
      {!!Form::password('usu_confirmar_password', ['class' => 'form-control'])!!}
    </div>
	</div>
</div>

 <div class = "box box-primary" >
     <div class = "box-header with-border"> 
      <h3>Especialidad(es) <button id="remove-all" name ="remove-all" class="btn btn-warning pull-right" type="button"><i class="fa fa-minus-circle" aria-hidden="true"></i></button></h3>
     </div>

     <div class = 'box-body' id="especialidades">
      @if(count($especialidades) == 1)
         <div class ="col-lg-7">
       {!! Form::Label('especialidades', 'Especialidad:') !!}
       @if($especialidades->esp_id != null)
          {!! Form::select('esp_id[]', $esp, $especialidades->esp_id , ['id' => 'esp_id[]', 'class' => 'form-control ' , 'placeholder' =>'Seleccione Especialidad']) !!}
       @else
          
          {!! Form::select('esp_id[]', $esp, null , ['id' => 'esp_id[]', 'class' => 'form-control ' , 'placeholder' =>'Seleccione Especialidad']) !!}
        @endif
        </div>
        <button id="add" name="add" class="btn btn-success pull-right " type="button"><i class="fa fa-plus" aria-hidden="true"></i></button>

      @elseif(count($especialidades)>1)
        @foreach($especialidades as $especialidad)
          <div class ="col-lg-7">
            @if($loop->first)
              {!! Form::Label('especialidades', 'Especialidad:') !!}
            @endif
         {!! Form::select('esp_id[]', $esp, $especialidad->esp_id , ['id' => 'esp_id[]', 'class' => 'form-control' , 'placeholder' =>'Seleccione Especialidad']) !!}
         </div>
         @if ($loop->first)
           <button id='add' name="add" class="btn btn-success pull-right" type="button"><b><i class="fa fa-plus" aria-hidden="true"></i></b></button>
          @else
          <button id='remove' name="remove" class="btn btn-danger pull-right" type="button"><i class="fa fa-minus" aria-hidden="true"></i></button>
         @endif
         
        @endforeach
      @endif
    </div>
      <div class="box-footer">
        <div class="form-horizontal" align="center">
          {!!Form::submit('Actualizar Usuario',['class'=>'btn btn-primary'])!!}
        </div>
    </div>
  </div>
   
  

<script type="text/javascript">


  $(function(){
      $("#rut").rut();
  }
  );

</script>


<script type="text/javascript">
  
  $(document).ready(function(){
    var i = 1;
    $(document).on('click', '#add', function(){
      
      var html = '';
      html += '<div class ="col-lg-7"> {!!Form::select('esp_id[]', $esp, null, ['id' => 'esp_id[]', 'class' => 'form-control ' , 'placeholder' =>'Seleccione Especialidad'])!!}   </div>';
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
      html_all +='{!! Form::select('esp_id[]', $esp, null , ['id' => 'esp_id[]', 'class' => 'form-control ' , 'placeholder' =>'Seleccione Especialidad']) !!} </div>';
      html_all += '<button id="add" name="add" class="btn btn-success pull-right " type="button" title= "Añadir nueva especialidad"><i class="fa fa-plus" aria-hidden="true"></i></button>';

      $('#especialidades').append(html_all);

    });
  });

  //funcion en la que tengo problema



</script>




{!!Form::close()!!}
@endsection