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

{!!Form::open(['route'=>'materiales.store', 'method' =>'POST', 'id'=>'materiales_create' ,'name'=>'materiales_create'])!!}
<div class="box box-primary">
  <div class="box-header">
    <h2> Nuevo Material</h2>
  </div>
  <div class ="box-body">
      <div class="col-lg-6">
        {!!Form::label('mat_codigo', 'Codigo Material')!!}
        {!!Form::number('mat_codigo', null, ['class'=>'form-control'])!!}
      </div>

      <div class="col-lg-6">
        {!!Form::label('mat_nombre_material', 'Nombre Material')!!}
        {!!Form::text('mat_nombre_material', null, ['class'=>'form-control'])!!}
      </div>

      <div class="col-lg-6">
        {!!Form::label('mat_costo', 'Costo')!!}
        {!!Form::number('mat_costo', null, ['class'=>'form-control'])!!}
      </div>

      <div class="col-lg-6">
        {!!Form::label('mat_stock', 'Unidades')!!}
        {!!Form::text('mat_stock', null, ['class'=>'form-control'])!!}
      </div> 

      <div class="col-lg-6">
        {!!Form::label('mat_stock_minimo', 'Mínimo Unidades ')!!}
        {!!Form::number('mat_stock_minimo', null, ['class'=>'form-control'])!!}
      </div>

      <div class="col-lg-6">
      {!!Form::label('mat_estado', 'Estado')!!}
      {!!Form::select('mat_estado', ['Disponible'=>'Disponible', 'Stock crítico' => 'Stock crítico', 'Sin stock' => 'Sin stock'], null, ['class' => 'form-control'])!!}
    </div>

    </div>
    <div class ="box-footer with-border">
        <div class="form-horizontal" align="center">
          {!!Form::submit('Crear Material',['class'=>'btn btn-success', 'id' => 'crear'])!!}
        </div>
      </div>
</div>





{!!Form::close()!!}



@endsection
