@extends('layouts.app')

@section('title', 'Crear Usuario')


@section('main-content')

@if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif

@if (session('destroyStatus'))
    <div class="alert alert-danger">
        {{ session('destroyStatus') }}
    </div>
@endif

  @if (count($errors) > 0)
      <div class="alert alert-danger">
          <ul>
              @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
              @endforeach
          </ul>
      </div> 
  @endif

{!!Form::open(['route'=>['usuarios.updateprofile', $usuario], 'method' =>'PUT', 'id'=>'usuarios_update' ,'name'=>'usuarios_update'])!!}
<div class="box box-primary">
	<div class="box-header">
		<h2>Perfil del Usuario {{$usuario->usu_nombres}} {{$usuario->usu_apellido_paterno}}</h2>
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
      {!!Form::text('usu_rol', $usuario->usu_rol, ['class' => 'form-control', 'readonly'=>'readonly'])!!}
    </div>		

    <div class="col-lg-6">
      {!!Form::label('usu_new_password', 'Contraseña Nueva')!!}
      {!!Form::password('usu_new_password', ['class' => 'form-control'])!!}
    </div>

    <div class="col-lg-6">
      {!!Form::label('usu_confirmar_password', 'Confirmar Contraseña')!!}
      {!!Form::password('usu_confirmar_password', ['class' => 'form-control'])!!}
    </div>
	</div>
</div>

<div class = "box box-primary" >
    <div class = "box-header with-border"> 
      <h3>Especialidad(es) <i class='fa fa-question-circle' title ="Solo El Administrador Puede Actualizar especialidades"></i></h3>
    </div>
    <div class = 'box-body' id="especialidades">
      @if($especialidades != NUll)
        @foreach($especialidades as $esp)
        <div class ="col-lg-7">
          @if($loop->first)
           {!! Form::Label('especialidades', 'Especialidad:') !!}
          @endif
           {!! Form::text('esp_id', $esp , ['class' => 'form-control', 'readonly '=>"readonly"]) !!}
        </div>
        @endforeach
      @endif             
    </div>
    <div class="box-footer">
    </div>
 </div>

 <div class="box box-primary">
   <div class = "box-header with-border"> 
      <h4>Debes Ingresar tu Contraseña Actual Para Almacenar los Cambios</h4>
   </div>
   <div class="box-body">

     <div class="col-lg-6">
      {!!Form::label('usu_password', 'Contraseña Actual')!!}
      {!!Form::password('usu_password', ['class' => 'form-control'])!!}
    </div>

   </div>
   <div class="box-footer">
     <div class="form-horizontal" align="center">
          {!!Form::submit('Actualizar Perfil',['class'=>'btn btn-primary'])!!}
      </div>
   </div>
 </div>
   
  

<script type="text/javascript">


  $(function(){
      $("#rut").rut();
  }
  );

</script>




{!!Form::close()!!}
@endsection