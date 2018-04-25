@extends('layouts.app')

@section('title', 'Crear Tratamiento')


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

  @if (count($errors) > 0)
      <div class="alert alert-danger">
          <ul>
              @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
              @endforeach
          </ul>
      </div>
  @endif

    {!!Form::open(['route'=>['tratamientos.update', $tratamientos->tra_id], 'method' =>'PUT', 'id'=>'tratamientos_edit' ,'name'=>'tratamientos_edit'])!!}

    <h2> Actualizar Tratamiento</h2>
<div class="box box-primary">
  <div class="box-body">
      <div class="col-lg-6">
        {!!Form::label('tra_nombre', 'Nombres Tratamiento')!!}
        {!!Form::text('tra_nombre', $tratamientos->tra_nombre, ['class'=>'form-control'])!!}
      </div>

      <div class="col-lg-6">
        {!!Form::label('tra_costo_laboratorio', 'Costo Laboratorio')!!}
       {!!Form::number('tra_costo_laboratorio', $tratamientos->tra_costo_laboratorio, ['class'=>'form-control', 'rows' => 4])!!}
      </div>
      
      <div class="col-lg-6">
        {!!Form::label('tra_costo', 'Costo Tratamiento')!!}
       {!!Form::number('tra_costo', $tratamientos->tra_costo, ['class'=>'form-control'])!!}
      </div>
   </div>
   <div class ="box-footer">
      <div class="form-horizontal" align="center">
        {!!Form::submit('Actualizar Tratamiento',['class'=>'btn btn-primary'])!!}
      </div>
    </div>
</div>


    {!!Form::close()!!}



@endsection
