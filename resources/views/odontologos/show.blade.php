@extends('layouts.app')

@section('title','Informacion Odontologo')


@section('main-content')

<h2>Informacion Odontologo: </h2>
<div class="col-lg-10">
<div class ="box box-primary">
	<div class = "box-header">
		<h3>{{$odontologo->odo_nombres}} {{$odontologo->odo_apellido_paterno}} {{$odontologo->odo_apellido_materno}}</h3>
	</div>
	<div class = "box-body">
		<table class="table table-bordered">

			<tr>
				<th class = "col-lg-5">Rut Odontologo</th>
				<td class = "col-lg-5">{{$odontologo->odo_rut}}-{{$odontologo->odo_dv}}</td>
			</tr>
			<tr>
				<th>Nombres Odontologo</th>
				<td>{{$odontologo->odo_nombres}}</td>
			</tr>
			<tr>
				<th>Apellidos</th>
				<td>{{$odontologo->odo_apellido_paterno}} {{$odontologo->odo_apellido_materno}}</td>
			</tr>
			<tr>
				<th>Fecha de Nacimiento</th>
				<td>{{$odontologo->odo_fecha_nacimiento}}</td>
			</tr>
			<tr>
				<th>Direccion</th>
				<td>{{$odontologo->odo_direccion}}</td>
			</tr>
			<tr>
				<th>Telefono</th>
				<td>{{$odontologo->odo_telefono}}</td>
			</tr>

			<tr>
				<th>Correo Electrónico</th>
				<td>{{$odontologo->odo_email}}</td>
			</tr>

			<tr>
				<th>Nombre de Usuario Odontologo</th>
				<td>{{$odontologo->odo_usuario}}</td>
			</tr>
			
		</table>
	</div>
</div>
</div>

@if($especialidades != NULL)
<div class="col-lg-10">
	<div class ="box box-success">
		<div class ="box-header">
			<h2>Especialidades</h2>
		</div>
		<div class ="box-body">
			<table class="table table-bordered">
			@if(count($especialidades) == 1)
			<tr>
				<th>Especialidad</th>
				<td>{{$especialidades->esp_nombre}}</td>
			</tr>
			@elseif(count($especialiadades > 1))
				@foreach($especialidades as $especialidad)
					<tr>
						<th>{{$loop->iteration}}</th>
						<td>{{$especialidad->esp_nombre}}</td>
					</tr>

				@endforeach
			@endif
			</table>
		</div>
	</div>
</div>
@endif

@endsection
