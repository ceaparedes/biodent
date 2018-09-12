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

<h2>Listado de Materiales <a class="btn btn-success pull-right" href="{{route('materiales.create')}}">Crear Nuevo Material</a></h2>
<div class="box box-primary">
	<div class ="box-body table-responsive no-padding">	
		<table class="table table-hover">
			<thead>
				<th>#</th>
				<th>Codigo</th>
				<th>Nombre Material</th>
				<th>Unidades</th>
				<th>Mínimo Unidades</th>
				<th>Costo</th>
				<th>Ultima Actualizacion</th>
				<th>Opciones</th>
			</thead>
			<tbody>
				@foreach($materiales as $material)
					<tr>
						<td>{{ $loop->iteration}}</td>
						<td>{{ $material->mat_codigo }}</td>
						<td>{{ $material->mat_nombre_material }}</td>
						<td>{{ $material->mat_stock }}</td>
						<td>{{ $material->mat_stock_minimo }}</td>
						<td>{{ number_format($material->mat_costo) }}</td>
						<td>{{ date('d-m-Y', strtotime($material->mat_fecha_actualizacion ))}}</td>
						<td>
							<!--<a href="{{ route('pacientes.show', $material->mat_id)}}" class="btn btn-info" title ="Ver Ficha Completa de Paciente"><i class="glyphicon glyphicon-file"></i></a>-->
							<a href="{{ route('recepciones-materiales.create', $material->mat_id)}}" class="btn btn-success" title ="Crear recepcion de materiales"><i class="fas fa-briefcase"></i></a>
							<a href="{{ route('materiales.edit', $material->mat_id)}}" class="btn btn-warning" title ="Actualizar Paciente"><i class="glyphicon glyphicon-wrench"></i></a>
							<a href="{{ route('materiales.destroy', $material->mat_id)}}" onclick= "return confirm('¿Esta seguro de Eliminar el Material?') " class="btn btn-danger" title ="Eliminar Paciente"><i class="glyphicon glyphicon-trash"></i></a>
						</td>
					</tr>
				@endforeach
			</tbody>

		</table>
	</div>
	<div class="box-footer"> 
		{{ $materiales->render() }}
	</div>
</div>
		




@endsection
