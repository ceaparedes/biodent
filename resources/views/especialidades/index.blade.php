@extends('layouts.app')

@section('title','Listado de Especialidades')


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

<h2>Listado de Especialidades <a class="btn btn-success pull-right" href="{{route('especialidades.create')}}">Crear Nueva Especialidad</a></h2>
<div class="box box-primary">
	<div class ="box-body table-responsive no-padding">	
		<table class="table table-hover">
			<thead>
				<th>#</th>
				<th>Nombre Especialidad</th>
				<th>Opciones</th>
			</thead>
			<tbody>
				@foreach($especialidades as $especialidad)
					<tr>
						<td>{{ $loop->iteration}}</td>
						<td>{{ $especialidad->esp_nombre }}</td>
						<td>
							<a href="{{ route('especialidades.edit', $especialidad->esp_id)}}" class="btn btn-warning"><i class="glyphicon glyphicon-wrench"></i></a> 
							<a href="{{ route('especialidades.destroy', $especialidad->esp_id)}}" onclick= "return confirm('¿Esta seguro de Eliminar la Especialidad?') " class="btn btn-danger"><i class="glyphicon glyphicon-trash"></i></a>
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>
	{{ $especialidades->render() }}
	</div>
</div>



@endsection
