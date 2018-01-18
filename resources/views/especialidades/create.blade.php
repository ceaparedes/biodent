@extends('layouts.app')

@section('title', 'Crear Especialidad')


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

  {!!Form::open(['route'=>'especialidades.store', 'method' =>'POST', 'id'=>'especialidades_create' ,'name'=>'especialidades_create'])!!}

  <h2> Crear Nueva Especialidad</h2>

  <div class="col-lg-7">
    {{form::label('esp_nombre', 'Especialidad')}}
    {{Form::text('esp_nombre', null, ['class'=>'form-control'])}}
  </div>

  <div class="form-horizontal col-lg-6 ">
    {{Form::submit('Crear Especialidad',['class'=>'btn btn-success'])}}
  </div>
{!!Form::close()!!}


@endsection