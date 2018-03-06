@extends('layouts.app')

@section('title', 'Actualizar Especialidad')


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

  {!!Form::open(['route'=>['especialidades.update', $especialidad->esp_id], 'method' =>'PUT', 'id'=>'especialidades_update' ,'name'=>'especialidades_update'])!!}

 <div class="box box-primary">
  <div class="box header with-border">
    <h2> Actualizar Especialidad</h2>
  </div>
  <div class="box-body">
    <div class="col-lg-7">
      {{form::label('esp_nombre', 'Especialidad')}}
      {{Form::text('esp_nombre', null, ['class'=>'form-control'])}}
    </div>

    <div class="form-horizontal col-lg-6 ">
      {{Form::submit('Crear Especialidad',['class'=>'btn btn-success'])}}
    </div>
  {!!Form::close()!!}
  </div>
</div>
{!!Form::close()!!}


@endsection