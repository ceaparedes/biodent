@extends('layouts.app')

@section('title', 'Crear Usuario')


@section('main-content')


{!!Form::open(['route'=>['usuarios.show', $usuario], 'method' =>'POST', 'id'=>'usuarios_show' ,'name'=>'usuarios_show'])!!}
<div class="box box-primary">
	<div class="box-header">
		<h2>{{$usuario->usu_nombres}} {{$usuario->usu_apellido_paterno}} -  {{$usuario->usu_rol}} </h2>
		<h3>Identificación Básica</h3>
	</div>
	<div class="box-body">

		<div class="col-lg-6">
			{!!Form::label('usu_nombres', 'Nombres Usuario')!!}
			{!!Form::text('usu_nombres', $usuario->usu_nombres, ['class' => 'form-control', 'readonly '=>"readonly"])!!}
		</div>

		<div class="col-lg-6">
			{!!Form::label('usu_apellido_paterno', 'Apellido Paterno')!!}
			{!!Form::text('usu_apellido_paterno', $usuario->usu_apellido_paterno, ['class' => 'form-control','readonly '=>"readonly"])!!}
		</div>

		<div class="col-lg-6">
			{!!Form::label('usu_apellido_materno', 'Apellido Materno')!!}
			{!!Form::text('usu_apellido_materno', $usuario->usu_apellido_materno, ['class' => 'form-control', 'readonly '=>"readonly"]) !!}	
		</div>

		<div class="col-lg-6">
			{!!Form::label('usu_rut_completo', 'Rut Usuario') !!}
			{!!Form::text('usu_rut_completo', $usuario->usu_rut_completo, ['class' => 'form-control', 'id' => 'rut', 'readonly '=>"readonly"]) !!}
		</div>

    <div class="col-lg-6">
      {!!Form::label('usu_fecha_nacimiento', 'Fecha de Nacimiento')!!}
      {!!Form::date('usu_fecha_nacimiento', $usuario->usu_fecha_nacimiento, ['class' =>'form-control', 'readonly '=>"readonly"])!!}
    </div>

		<div class="col-lg-6">
			{!!Form::label('usu_direccion', 'Dirección')!!}
			{!!Form::text('usu_direccion', $usuario->usu_direccion, ['class' =>'form-control', 'readonly '=>"readonly"])!!}
		</div>

		<div class="col-lg-6">
			{!!Form::label('com_nombre', 'Comuna de Residencia')!!}
			{!!Form::text('com_nombre', $comuna->com_nombre, ['class' => 'form-control', 'readonly '=>"readonly"])!!}
		</div>

		<div class="col-lg-6">
			{!!Form::label('usu_email', 'Email Usuario') !!}
			{!!Form::text('usu_email', $usuario->usu_email, ['class'=> 'form-control', 'readonly '=>"readonly"]) !!}
		</div>

		<div class="col-lg-6">
			{!!Form::label('usu_telefono', 'Teléfono de Contacto')!!}
			{!!Form::number('usu_telefono', $usuario->usu_telefono, ['class'=> 'form-control', 'readonly '=>"readonly"])!!}
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
			{!!Form::text('usu_usuario', $usuario->usu_usuario, ['class' => 'form-control', 'readonly '=>"readonly"])!!}
		</div>

		<div class="col-lg-6">
			{!!Form::label('usu_rol', 'Rol del Usuario')!!}
			{!!Form::text('usu_rol',  $usuario->usu_rol, ['class' => 'form-control','readonly '=>"readonly"])!!}
		</div>
	</div>
</div>

<div class = "box box-primary" >
    <div class = "box-header with-border"> 
      <h3>Especialidad(es) <i class='fa fa-question-circle' title ="Solo los Odontólogos y Administrador pueden tener Especialidades"></i></h3>
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

<script type="text/javascript">


  $(function(){
      $("#rut").rut();
  }
  );

</script>


<script type="text/javascript">


</script>




{!!Form::close()!!}
@endsection