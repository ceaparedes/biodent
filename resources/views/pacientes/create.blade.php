@extends('layouts.app')

@section('title', 'Crear Paciente')


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

    {!!Form::open(['route'=>'pacientes.store', 'method' =>'POST', 'id'=>'pacientes_create' ,'name'=>'pacientes_create'])!!}

    <h2> Ficha Dental</h2>

      <div class="col-lg-6">
        {!!Form::label('pac_nombres', 'Nombres Paciente')!!}
        {!!Form::text('pac_nombres', null, ['class'=>'form-control'])!!}
      </div>

      <div class="col-lg-6">
        {!!Form::label('pac_apellidos', 'Apellidos')!!}
        {!!Form::text('pac_apellidos', null, ['class'=>'form-control'])!!}
      </div>

      <div class="col-lg-6">
        {!!Form::label('pac_edad', 'Edad')!!}
        {!!Form::number('pac_edad', null, ['class'=>'form-control'])!!}
      </div>

       <div class="col-lg-6">
        {!!Form::label('pac_rut_completo', 'Rut Paciente')!!}
        {!!Form::text('pac_rut_completo', null, ['class'=>'form-control','id'=>'rut'])!!}
      </div> 

      <div class="col-lg-6">
        {!!Form::label('pac_direccion', 'Direccion')!!}
        {!!Form::text('pac_direccion', null, ['class'=>'form-control'])!!}
      </div>

      <div class=" col-lg-6">
        {!!Form::label('pac_telefono', 'Teléfono')!!}
        {!!Form::number('pac_telefono', null, ['class'=>'form-control'])!!}
      </div>

      <div class="col-lg-12">
        {!!Form::label('pac_motivo', 'Motivo')!!}
        {!!Form::textarea('pac_motivo', null, ['class'=>'form-control'])!!}
      </div>


    <h2> Anamnesis</h2>

      <div class="form-group">
    {!! Form::Label('tipos', 'Tipo:') !!}
    {!! Form::select('tan_id', $tipos, null, ['class' => 'form-control']) !!}
    </div>


   <div class="col-lg-12">
        {!!Form::label('amg_descripcion', 'Descripcion:')!!}
        {!!Form::textarea('amg_descripcion', null, ['class'=>'form-control'])!!}
      </div>




    <h2> Examen Intraoral</h2>

     <div class="col-lg-12">
        {!!Form::label('pac_observaciones', 'Observaciones')!!}
        {!!Form::textarea('pac_observaciones', null, ['class'=>'form-control'])!!}
      </div>

      <div class="form-horizontal">
        {!!Form::submit('Crear Paciente',['class'=>'btn btn-success'])!!}
      </div>

<script type="text/javascript">


  $(function(){
      $("#rut").rut();
  }
  );
</script>


    {!!Form::close()!!}



@endsection
