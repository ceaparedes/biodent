@extends('layouts.app')

@section('title','Listado de Planes de Tratamientos')


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

<h2>Listado de Sesiones de Tratamiento: {{$paciente->pac_nombres}} {{$paciente->pac_apellido_paterno}} {{$paciente->pac_apellido_materno}}<a class="btn btn-success pull-right" href="{{route('sesiones-ejecucion-tratamientos.create', $id)}}">Crear Nueva sesión de Tratamiento</a></h2>
<div class="box box-primary">
	<div class ="box-body table-responsive no-padding">	
		<table class="table table-hover">
			<thead>
				<th>#</th>
				<th>Nombre Paciente</th>
				<th>Fecha Creación Sesión</th>
				<th>Costo Total Plan</th>
				<th>Odontólogo</th>
				<th>Estado Plan</th>
				<th>Opciones</th>
			</thead>
			<tbody>
				@foreach($sesiones as $sesion)
					<tr>
						<td>{{ $loop->iteration}}</td>
						<td>{{ $paciente->pac_nombres}} {{$paciente->pac_apellido_paterno}} {{$paciente->pac_apellido_materno }}</td>
						<td>{{ date('d-m-Y', strtotime($sesion->set_fecha )) }}</td>
						<td>{{ number_format($plan->pdt_costo_total) }}</td>
						<td>{{ $sesion->odontologo->usu_nombres}} {{$sesion->odontologo->usu_apellido_paterno}} {{$sesion->odontologo->usu_apellido_materno }}</td>
						<td>{{ $plan->estado->ept_estado}}</td>
						<td>
							<a href="{{route('sesiones-ejecucion-tratamientos.show',$sesion->set_id)}}" class="btn btn-info" title ="Ver detalle de Sesión"><i class="glyphicon glyphicon-file"></i></a>
							@if(Auth::user()->usu_rol == 'Administrador')
							<a href="{{route('sesiones-ejecucion-tratamientos.destroy',$sesion->set_id)}}" onclick= "return confirm('¿Esta seguro de Eliminar La sesión creada?') " class="btn btn-danger" title ="Eliminar Paciente"><i class="glyphicon glyphicon-trash"></i></a>
							@endif
						</td>
					</tr>
				@endforeach
			</tbody>

		</table>
	</div>
	<div class="box-footer"> 
		{{ $sesiones->render() }}
	</div>
</div>
		




@endsection
