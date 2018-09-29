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

<h2>Listado de Pacientes <a class="btn btn-success pull-right" href="{{route('pacientes.create')}}">Crear Nuevo Paciente</a></h2>
<div class="box box-primary">
	<div class ="box-body table-responsive no-padding">	
		<table class="table table-hover">
			<thead>
				<th>#</th>
				<th>Rut Paciente</th>
				<th>Nombre Pacientes</th>
				<th>Comuna de residencia</th>
				<th>Email paciente</th>
				<th>Teléfono</th>
				<th>Opciones</th>
			</thead>
			<tbody>
				@foreach($pacientes as $paciente)
					<tr>
						<td>{{ $loop->iteration}}</td>
						<td>{{ $paciente->pac_rut }}-{{ $paciente->pac_dv }}</td>
						<td>{{ $paciente->pac_nombres }} {{ $paciente->pac_apellido_paterno }} {{ $paciente->pac_apellido_materno }}</td>
						<td>{{$paciente->comuna->com_nombre}}</td>
						<td>{{ $paciente->pac_email}}</td>
						<td>{{ $paciente->pac_telefono }}</td>
						<td>
							<a href="{{ route('pacientes.show', $paciente->pac_id)}}" class="btn btn-info" title ="Ver Ficha Completa de Paciente"><i class="glyphicon glyphicon-file"></i></a>
							<a href="{{ route('pacientes.edit', $paciente->pac_id)}}" class="btn btn-warning" title ="Actualizar Paciente"><i class="glyphicon glyphicon-wrench"></i></a>
							@if($paciente->plan_existente > 0)
							<a href="{{ route('planes-de-tratamientos.pacienteindex', $paciente->pac_id)}}" class="btn btn-success" title ="Crear nuevo Plan de Tratamiento"><i class="fas fa-file-medical-alt"></i></a>
							@else
							<a href="{{ route('planes-de-tratamientos.create', $paciente->pac_id)}}" class="btn btn-success" title ="ver Planes de Tratamientos"><i class="fas fa-file-medical-alt"></i></a>
							@endif
							@if(Auth::user()->usu_rol == 'Administrador')
							<a href="{{ route('pacientes.destroy', $paciente->pac_id)}}" onclick= "return confirm('¿Esta seguro de Eliminar al paciente?') " class="btn btn-danger" title ="Eliminar Paciente"><i class="glyphicon glyphicon-trash"></i></a>
							@endif
						</td>
					</tr>
				@endforeach
			</tbody>

		</table>
	</div>
	<div class="box-footer"> 
		{{ $pacientes->render() }}
	</div>
</div>
		




@endsection
