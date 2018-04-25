@extends('layouts.app')

@section('title', 'Crear Especialidad')


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

  {!!Form::open(['route'=>'especialidades.store', 'method' =>'POST', 'id'=>'especialidades_create' ,'name'=>'especialidades_create'])!!}
<div class="box box-primary">
  <div class="box header">
    <h2> Crear Nueva Especialidad</h2>
  </div>
  <div class="box-body">
    <div class="col-lg-7">
      {{form::label('esp_nombre', 'Especialidad')}}
      {{Form::text('esp_nombre', null, ['class'=>'form-control'])}}
    </div>
  </div>
  <div class="box-footer">
    <div class="form-horizontal col-lg-6 ">
      {{Form::submit('Crear Especialidad',['class'=>'btn btn-success'])}}
    </div>
  {!!Form::close()!!}
  </div>
</div>

@endsection