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

<h2>Renovaciones de Material : {{$material->mat_nombre_material}} <a class="btn btn-primary pull-right" href="{{route('materiales.index')}}"><i class="fas fa-arrow-left"></i> Volver</a></h2>
<div class="box box-primary">
	<div class ="box-body table-responsive no-padding">	
		<table class="table table-hover">
			<thead>
				<th>#</th>
				<th>Proveedor</th>
				<th>cantidad comprada</th>
				<th>Costo</th>
				<th>Fecha de Compra</th>
				<!--<th>Opciones</th>-->
			</thead>
			<tbody>
				@foreach($recepciones as $aux)
					<tr>
						<td>{{ $loop->iteration}}</td>
						<td>{{ $aux->rep_proveedor }}</td>
						<td>{{ $aux->rep_cantidad }}</td>
						<td>{{ $aux->rep_monto }}</td>
						<td>{{ $aux->rep_fecha_compra }}</td>
						<!--
						<td>
							<a href="{{ route('pacientes.show', $material->mat_id)}}" class="btn btn-info" title ="Ver Ficha Completa de Paciente"><i class="glyphicon glyphicon-file"></i></a>
							<a href="{{ route('recepciones-materiales.create', $material->mat_id)}}" class="btn btn-success" title ="Eliminar Paciente"><i class="fas fa-briefcase"></i></a>
							<a href="{{ route('materiales.edit', $material->mat_id)}}" class="btn btn-warning" title ="Actualizar Paciente"><i class="glyphicon glyphicon-wrench"></i></a>
							<a href="{{ route('materiales.destroy', $material->mat_id)}}" onclick= "return confirm('¿Esta seguro de Eliminar el Material?') " class="btn btn-danger" title ="Eliminar Paciente"><i class="glyphicon glyphicon-trash"></i></a>
						</td>
						-->
					</tr>
				@endforeach
			</tbody>

		</table>
	</div>
	<div class="box-footer"> 
		{{ $recepciones->render() }}
	</div>
</div>
		




@endsection
