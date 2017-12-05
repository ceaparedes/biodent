@extends('layouts.app')

@section('title','Ficha de Pacientes')


@section('main-content')

<h2>Ficha Dental</h2>

<table class="table">

	<tr>
		<th>Rut Paciente</th>
		<td>{{$paciente->pac_rut}}-{{$paciente->pac_dv}}</td>
	</tr>
	<tr>
		<th>Nombres Paciente</th>
		<td>{{$paciente->pac_nombres}}</td>
	</tr>
	<tr>
		<th>Apellidos</th>
		<td>{{$paciente->pac_apellido_paterno}} {{$paciente->pac_apellido_materno}}</td>
	</tr>
	<tr>
		<th>Edad</th>
		<td>{{$paciente->pac_edad}}</td>
	</tr>
	<tr>
		<th>Direccion</th>
		<td>{{$paciente->pac_direccion}}</td>
	</tr>
	<tr>
		<th>Telefono</th>
		<td>{{$paciente->pac_telefono}}</td>
	</tr>
	<tr>
		<th>Motivo</th>
		<td>{{$paciente->pac_motivo}}</td>
	</tr>

	@if($antecedentes )
	<tr><h3>Anamnesis</h3></tr>
	<tr>
		<th>Tipo</th>
		<td>{{$antecedentes->tan_id}}</td>
	</tr>
	<tr>
		<th>Descipcion</th>
		<td>{{$$antecedentes->amg_descripcion}}</td>
	</tr>
	@endif

	<tr>
		<th>observaciones</th>
		<td>{{$paciente->pac_observaciones}}</td>
	</tr>

	
</table>


@endsection
