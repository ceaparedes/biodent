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

<h2>Listado de Planes de Tratamientos</h2>
<div class="box box-primary">
	<div class ="box-body table-responsive no-padding">	
		<table class="table table-hover">
			<thead>
				<th>#</th>
				<th>Nombre Paciente</th>
				<th>Fecha Creación plan</th>
				<th>Costo Total Plan</th>
				<th>Odontólogo Creador</th>
				<th>Estado</th>
				<th>Opciones</th>
			</thead>
			<tbody>
				@foreach($planes as $plan)
					<tr>
						<td>{{ $loop->iteration}}</td>
						<td>{{ $plan->paciente->pac_nombres}} {{$plan->paciente->pac_apellido_paterno}} {{$plan->paciente->pac_apellido_materno }}</td>
						<td>{{ date('d-m-Y', strtotime($plan->pdt_fecha_inicio )) }}</td>
						<td>{{ number_format($plan->pdt_costo_total) }}</td>
						<td>{{ $plan->odontologo->usu_nombres}} {{$plan->odontologo->usu_apellido_paterno}} {{$plan->odontologo->usu_apellido_materno }}</td>
						<td>{{ $plan->estado->ept_estado}}</td>
						<td>
							<a href="{{route('planes-de-tratamientos.show',$plan->pdt_id)}}" class="btn btn-info" title ="Ver detalle de plan"><i class="glyphicon glyphicon-file"></i></a>
							<a href="{{route('planes-de-tratamientos.edit',$plan->pdt_id)}}" class="btn btn-warning" title ="Actualizar Plan"><i class="glyphicon glyphicon-wrench"></i></a>
							@if($plan->abonos > 0 ) 
								<a href="{{route('abonos-tratamientos.index', $plan->pdt_id)}}" class="btn btn-success" title ="Ver Abonos realizados para el Plan"><i class="fas fa-hand-holding-usd"></i></a>
							@else
								<a href="{{route('abonos-tratamientos.create', $plan->pdt_id)}}" class="btn btn-success" title ="Ver Abonos realizados para el Plan"><i class="fas fa-hand-holding-usd"></i></a>
							@endif
							@if($plan->sesiones > 0)
								<a href="{{route('sesiones-ejecucion-tratamientos.index', $plan->pdt_id)}}" class="btn btn-success" title ="Ver Abonos realizados para el Plan"><i class="fas fa-list-ul"></i></a>
							@else
								<a href="{{route('sesiones-ejecucion-tratamientos.create', $plan->pdt_id)}}" class="btn btn-success" title ="Ver Abonos realizados para el Plan"><i class="fas fa-list-ul"></i></a>
							@endif
							<a href="{{route('planes-de-tratamientos.destroy',$plan->pdt_id)}}" onclick= "return confirm('¿Esta seguro de Eliminar plan creado?') " class="btn btn-danger" title ="Eliminar Paciente"><i class="glyphicon glyphicon-trash"></i></a>
						</td>
					</tr>
				@endforeach
			</tbody>

		</table>
	</div>
	<div class="box-footer"> 
		{{ $planes->render() }}
	</div>
</div>
		




@endsection
