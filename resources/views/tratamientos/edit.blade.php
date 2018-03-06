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

    {!!Form::open(['route'=>['tratamientos.update', $tratamientos->tra_id], 'method' =>'put', 'id'=>'tratamientos_edit' ,'name'=>'tratamientos_edit'])!!}

    <h2> Actualizar Tratamiento</h2>
<div class="box box-primary">
  <div class="box-body">
      <div class="col-lg-6">
        {!!Form::label('tra_nombre', 'Nombres Tratamiento')!!}
        {!!Form::text('tra_nombre', $tratamientos->tra_nombre, ['class'=>'form-control'])!!}
      </div>

      <div class="col-lg-12">
        {!!Form::label('tra_descripcion', 'Descripcion breve')!!}
        {!!Form::textarea('tra_descripcion', $tratamientos->tra_descripcion, ['class'=>'form-control'])!!}
      </div>
      
      <div class="col-lg-7">
        {!!Form::label('tra_costo', 'Costo Tratamiento')!!}
       {!!Form::number('tra_costo', $tratamientos->tra_costo, ['class'=>'form-control'])!!}
      </div>
   

      <div class="form-horizontal col-lg-7">
        {!!Form::submit('Crear Tratamiento',['class'=>'btn btn-primary'])!!}
      </div>
    </div>
</div>


    {!!Form::close()!!}



@endsection
