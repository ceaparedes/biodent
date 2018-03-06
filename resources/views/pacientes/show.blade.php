@extends('layouts.app')

@section('title','Ficha de Pacientes')


@section('main-content')

<h2>Ficha Dental </h2>
<div class ="col-lg-10">
	<div class="box box-primary">
		<div class="box-header">
			<h3>{{$paciente->pac_nombres}} {{$paciente->pac_apellido_paterno}} {{$paciente->pac_apellido_materno}}</h3>
		</div>
		<div class="box-body">
			<table class="table table-bordered">
				<tr>
					<th class = "col-lg-5">Rut Paciente</th>
					<td class = "col-lg-5">{{$paciente->pac_rut}}-{{$paciente->pac_dv}}</td>
				</tr>
				<tr>
					<th class = "col-lg-5">Nombres Paciente</th>
					<td class = "col-lg-5">{{$paciente->pac_nombres}}</td>
				</tr>
				<tr>
					<th class = "col-lg-5">Apellidos</th>
					<td class = "col-lg-5">{{$paciente->pac_apellido_paterno}} {{$paciente->pac_apellido_materno}}</td>
				</tr>
				<tr>
					<th class = "col-lg-5">Edad</th>
					<td class = "col-lg-5">{{$paciente->pac_edad}}</td>
				</tr>
				<tr>
					<th class = "col-lg-5">Direccion</th>
					<td class = "col-lg-5">{{$paciente->pac_direccion}}</td>
				</tr>
				<tr>
					<th class = "col-lg-5">Telefono</th>
					<td class = "col-lg-5">{{$paciente->pac_telefono}}</td>
				</tr>
				<tr>
					<th class = "col-lg-5">Motivo</th>
					<td class = "col-lg-5">{{$paciente->pac_motivo}}</td>
				</tr>

				<tr>
					<th class = "col-lg-5">observaciones</th>
					<td class = "col-lg-5">{{$paciente->pac_observaciones}}</td>
				</tr>

			</table>
		</div>
</div>
</div>


<div class="col-lg-10">
	<div class="box box-success">
		<div class="box-header">
			<h3>Antecedentes Medicos Generales (ANAMNESIS)</h3>
		</div>
		<div class="box-body">
			@if(count($antecedentes) == 1)
				<table class="table table-bordered">
					<tr>
						<th class = "col-lg-5">Tipo</th>
						<td class = "col-lg-5">{{$antecedentes->tan_id}}</td>
					</tr>
					<tr>
						<th class = "col-lg-5">observaciones</th>
						<td class = "col-lg-5">{{$antecedentes->amg_descripcion}}</td>
					</tr>
				</table>
			@else
			<table class="table table-bordered">
				<thead>
					<th>tipo antecedente</th>
					<th>descripcion</th>
				</thead>
				@foreach($antecedentes as $antecedente)
						<tbody>
							<td>{{ $antecedente->tan_id }}</td>
							<td>{{ $antecedente->amg_descripcion }}</td>
						</tbody>
					
				@endforeach
				</table>
			@endif
			</table>
		</div>				
	</div>
</div>


@endsection
