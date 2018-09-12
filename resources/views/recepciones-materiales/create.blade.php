@extends('layouts.app')

@section('title', 'Crear Paciente')


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

{!!Form::open(['route'=>['recepciones-materiales.store', $material->mat_id], 'method' =>'POST', 'id'=>'materiales_create' ,'name'=>'materiales_create'])!!}
<div class="box box-primary">
  <div class="box-header">
    <h2> Recepcion Material: {{$material->mat_nombre_material}}</h2>
  </div>
  <div class ="box-body">
      <div class="col-lg-6">
        {!!Form::label('mat_codigo', 'Codigo Material')!!}
        {!!Form::number('mat_codigo', $material->mat_codigo, ['class'=>'form-control', 'readonly' => 'readonly'])!!}
      </div>

      <div class="col-lg-6">
        {!!Form::label('rep_codigo', 'Codigo Recepcion')!!}
        {!!Form::text('rep_codigo', null, ['class'=>'form-control'])!!}
      </div>

      <div class="col-lg-6">
        {!!Form::label('rep_proveedor', 'Proveedor')!!}
        {!!Form::text('rep_proveedor', null, ['class'=>'form-control'])!!}
      </div>

      <div class="col-lg-6">
        {!!Form::label('rep_cantidad', 'Cantidad')!!}
        {!!Form::number('rep_cantidad', null, ['class'=>'form-control'])!!}
      </div> 

      <div class="col-lg-6">
        {!!Form::label('rep_monto', 'Costo Material')!!}
        {!!Form::text('rep_monto', null, ['class'=>'form-control'])!!}
      </div>

    </div>
    <div class ="box-footer with-border">
        <div class="form-horizontal" align="center">
          {!!Form::submit('Crear Recepcion',['class'=>'btn btn-success', 'id' => 'crear'])!!}
        </div>
      </div>
</div>





{!!Form::close()!!}



@endsection
