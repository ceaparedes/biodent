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

<table class="table">
	<thead>
		<th>#</th>
		<th>Nombre Tratamiento</th>
		<th>Descripcion</th>
		<th>Costo</th>
		<th>Opciones</th>
	</thead>
	<tbody>
		@foreach($tratamientos as $tratamiento)
			<tr>
				<td>{{ $loop->iteration}}</td>
				<td>{{ $tratamiento->tra_nombre }}</td>
				<td>{{ $tratamiento->tra_descripcion }}</td>
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




@endsection