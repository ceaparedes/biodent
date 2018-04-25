@extends('layouts.app')

@section('title','Listado de Tratamientos')


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

<h2>Listado de Tratamientos</h2>
<div class="box box-primary">
	<div class ="box-body table-responsive no-padding">	
		<table class="table table-hover">
			<thead>
				<th>#</th>
				<th>Nombre Tratamiento</th>
				<th>Gasto de Laboratorio</th>
				<th>Costo Total Tratamiento</th>
				<th>Opciones</th>
			</thead>
			<tbody>
				@foreach($tratamientos as $tratamiento)
					<tr>
						<td>{{ $loop->iteration}}</td>
						<td>{{ $tratamiento->tra_nombre }}</td>
						<td>{{ $tratamiento->tra_costo_laboratorio}}</td>
						<td>{{ $tratamiento->tra_costo }}</td>
						<td>
							<a href=" {{route('tratamientos.edit',$tratamiento->tra_id)}} " class="btn btn-warning"><i class="glyphicon glyphicon-wrench"></i></a> 
							<a href="{{route('tratamientos.destroy',$tratamiento->tra_id)}} " onclick= "return confirm('¿Esta seguro de Eliminar al tratamiento?') " class="btn btn-danger"><i class="glyphicon glyphicon-trash"></i></a>
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>
		{{ $tratamientos->render() }}
	</div>
</div>


@endsection
