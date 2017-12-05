@extends('layouts.app')

@section('title','Listado de Pacientes')


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

<h2>Listado de Pacientes</h2>

<table class="table">
	<thead>
		<th>Rut Paciente</th>
		<th>DV</th>
		<th>Nombres Pacientes</th>
		<th>Apellido Paterno</th>
		<th>Apellido Materno</th>
		<th>Observaciones</th>
		<th>Opciones</th>
	</thead>
	<tbody>
		@foreach($pacientes as $paciente)
			<tr>
				<td>{{ $paciente->pac_rut }}</td>
				<td>{{ $paciente->pac_dv }}</td>
				<td>{{ $paciente->pac_nombres }}</td>
				<td>{{ $paciente->pac_apellido_paterno }}</td>
				<td>{{ $paciente->pac_apellido_materno }}</td>
				<td>{{ $paciente->pac_observaciones }}</td>
				<td>
					<a href="{{ route('pacientes.show', $paciente->pac_id)}}" class="btn btn-info"><i class="glyphicon glyphicon-file"></i></a>
					<a href="{{ route('pacientes.edit', $paciente->pac_id)}}" class="btn btn-warning"><i class="glyphicon glyphicon-wrench"></i></a> 
					<a href="{{ route('pacientes.destroy', $paciente->pac_id)}}" onclick= "return confirm('¿Esta seguro de Eliminar al paciente?') " class="btn btn-danger"><i class="glyphicon glyphicon-trash"></i></a>
				</td>
			</tr>
		@endforeach
	</tbody>

</table>
{{ $pacientes->render() }}




@endsection
