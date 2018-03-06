@extends('layouts.app')

@section('title', 'Crear Tratamiento')


@section('main-content')

  @if (count($errors) > 0)
      <div class="alert alert-danger">
          <ul>
              @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
              @endforeach
          </ul>
      </div>
  @endif

    {!!Form::open(['route'=>'tratamientos.store', 'method' =>'POST', 'id'=>'tratamientos_create' ,'name'=>'tratamientos_create'])!!}
<div class="box box-primary">
  <div class="box header with-border">
    <h2> Crear un Nuevo Tratamiento</h2>
  </div>
  <div class="box-body">
      <div class="col-lg-6">
        {!!Form::label('tra_nombre', 'Nombres Tratamiento')!!}
        {!!Form::text('tra_nombre', null, ['class'=>'form-control'])!!}
      </div>

      <div class="col-lg-12">
        {!!Form::label('tra_descripcion', 'Descripcion breve')!!}
        {!!Form::textarea('tra_descripcion', null, ['class'=>'form-control'])!!}
      </div>
      
      <div class="col-lg-7">
        {!!Form::label('tra_costo', 'Costo Tratamiento')!!}
       {!!Form::number('tra_costo', null, ['class'=>'form-control'])!!}
      </div>
   </div>
   <div class="box-footer">
      <div class="form-horizontal col-lg-7">
        {!!Form::submit('Crear Tratamiento',['class'=>'btn btn-success'])!!}
      </div>
  </div>
</div>
    {!!Form::close()!!}



@endsection
