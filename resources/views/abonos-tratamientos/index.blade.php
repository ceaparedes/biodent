@extends('layouts.app')

@section('title','Listado de Abonos de Tratamientos')


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
@if($mensaje)
<div class="alert alert-success">
        <h5>· El tratamiento esta totalmente cancelado</h5>
    </div>
@endif

<h2>Listado de Abonos Realizados @if(!$mensaje)<a class="btn btn-success pull-right" href="{{route('abonos-tratamientos.index', $id)}}">Crear Nuevo Plan de Tratamiento</a>@endif</h2>
<div class="box box-primary">
	<div class ="box-body table-responsive no-padding">	
		<table class="table table-hover">
			<thead>
				<th>#</th>
				<th>Nombre Paciente</th>
				<th>Fecha Abono</th>
				<th>Monto Abonado</th>
				<th>Opciones</th>
			</thead>
			<tbody>
				@foreach($abonos as $aux)
					<tr>
						<td>{{ $loop->iteration}}</td>
						<td>{{ $aux->paciente->pac_nombres}} {{$aux->paciente->pac_apellido_paterno}} {{$aux->paciente->pac_apellido_materno }}</td>
						<td>{{ date('d-m-Y', strtotime($aux->abt_fecha)) }}</td>
						<td>{{ number_format($aux->abt_monto_abonado) }}</td>
						@if(Auth::user()->usu_rol == 'Administrador')
						<td>
							<a href="{{route('abonos-tratamientos.destroy', $aux->abt_id)}}" onclick= "return confirm('¿Esta seguro de Eliminar el Abono creado?') " class="btn btn-danger" title ="Eliminar Abono"><i class="glyphicon glyphicon-trash"></i></a>
						</td>
						@endif
					</tr>
				@endforeach
			</tbody>

		</table>
	</div>
	<div class="box-footer"> 
		{{ $abonos->render() }}
	</div>
</div>
		




@endsection
