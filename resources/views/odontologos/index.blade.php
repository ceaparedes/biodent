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

<h1>Listado de Dentistas</h1>
<div class="box box-primary">
	<div class ="box-body table-responsive no-padding">	
		<table class="table table-hover">
			<thead>
				<th>#</th>
				<th>Rut Odontologo</th>
				<th>DV</th>
				<th>Nombres Odontologo</th>
				<th>Apellido Paterno</th>
				<th>Apellido Materno</th>
				<th>Opciones</th>
			</thead>
			<tbody>
				@foreach($odontologos as $odontologo)
					<tr>
						<td>{{ $loop->iteration}}</td>
						<td>{{ $odontologo->odo_rut }}</td>
						<td>{{ $odontologo->odo_dv }}</td>
						<td>{{ $odontologo->odo_nombres }}</td>
						<td>{{ $odontologo->odo_apellido_paterno }}</td>
						<td>{{ $odontologo->odo_apellido_materno }}</td>
						<td>
							<a href="{{ route('odontologos.show', $odontologo->odo_id)}}" class="btn btn-info"><i class="glyphicon glyphicon-file"></i></a>
							<a href="{{ route('odontologos.edit', $odontologo->odo_id)}}" class="btn btn-warning"><i class="glyphicon glyphicon-wrench"></i></a> 
							<a href="{{ route('odontologos.destroy', $odontologo->odo_id)}}" onclick= "return confirm('¿Esta seguro de Eliminar al odontologo?') " class="btn btn-danger"><i class="glyphicon glyphicon-trash"></i></a>
						</td>
					</tr>
				@endforeach
			</tbody>

		</table>
		<div class ="dataTables_paginate paging_simple_numbers">
	  		{{ $odontologos->render() }}
	  </div>
	</div>
</div>





@endsection()