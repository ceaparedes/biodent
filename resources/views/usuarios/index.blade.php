@extends('layouts.app')

@section('title','Listado de Odontologos')


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

<h2>Listado de Usuarios <a class="btn btn-success pull-right" href="{{route('usuarios.create')}}">Crear Nuevo Usuario</a></h2>
<div class="box box-primary">
	<div class ="box-body table-responsive no-padding">	
		<table class="table table-hover">
			<thead>
				<th>#</th>
				<th>Rut Usuario</th>
				<th>Nombre Usuario</th>
				<th>Teléfono</th>
				<th>Nombre de Usuario</th>
				<th>Rol del Usuario</th>
				<th>Opciones</th>
			</thead>
			<tbody>
				@foreach($usuarios as $usuario)
					<tr>
						<td>{{ $loop->iteration}}</td>
						<td>{{ $usuario->usu_rut }}-{{$usuario->usu_dv}}</td>
						<td>{{ $usuario->usu_nombres}} {{ $usuario->usu_apellido_paterno }} {{ $usuario->usu_apellido_materno }}</td>
						<td>{{ $usuario->usu_telefono }}</td>
						<td>{{ $usuario->usu_usuario}}</td>
						<td>{{ $usuario->usu_rol }} </td>
						<td>
							<a href="{{ route('usuarios.show', $usuario->usu_id)}}" class="btn btn-info" title="Ver detalle del usuario"><i class="glyphicon glyphicon-file"></i></a>
							<a href="{{ route('usuarios.edit', $usuario->usu_id)}}" class="btn btn-warning" title="Actualizar Información del Usuario"><i class="glyphicon glyphicon-wrench"></i></a> 
							<a href="{{ route('usuarios.destroy', $usuario->usu_id)}}" onclick= "return confirm('¿Esta seguro de Eliminar al Usuario?') " class="btn btn-danger" title="Eliminar Usuario"><i class="glyphicon glyphicon-trash"></i></a>
						</td>
					</tr>
				@endforeach
			</tbody>

		</table>
		<div class ="dataTables_paginate paging_simple_numbers">
	  		{{ $usuarios->render() }}
	  </div>
	</div>
</div>





@endsection()