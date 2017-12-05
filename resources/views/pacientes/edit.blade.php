@extends('layouts.app')

@section('title', 'Editar Paciente ' )


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

   {!! Form::model($pacientes,['route'=>['pacientes.update',$pacientes],'method'=>'PUT'])!!}
    <h2> Ficha Dental</h2>

      <div class="col-lg-6">
        {!!Form::label('pac_nombres', 'Nombres Paciente')!!}
        {!!Form::text('pac_nombres', $pacientes->pac_nombres, ['class'=>'form-control'])!!}
      </div>

      <div class="col-lg-6">
        {!!Form::label('pac_apellidos', 'Apellidos')!!}
        {!!Form::text('pac_apellidos', $pacientes->pac_apellidos, ['class'=>'form-control'])!!}
      </div>

      <div class="col-lg-6">
        {!!Form::label('pac_edad', 'Edad')!!}
        {!!Form::number('pac_edad', $pacientes->pac_edad, ['class'=>'form-control'])!!}
      </div>

       <div class="col-lg-6">
        {!!Form::label('pac_rut_completo', 'Rut Paciente')!!}
        {!!Form::text('pac_rut_completo', $pacientes->pac_rut_completo, ['class'=>'form-control','id'=>'rut'])!!}
      </div> 

      <div class="col-lg-6">
        {!!Form::label('pac_direccion', 'Direccion')!!}
        {!!Form::text('pac_direccion', $pacientes->pac_direccion, ['class'=>'form-control'])!!}
      </div>

      <div class=" col-lg-6">
        {!!Form::label('pac_telefono', 'Teléfono')!!}
        {!!Form::number('pac_telefono', $pacientes->pac_telefono, ['class'=>'form-control'])!!}
      </div>

      <div class="col-lg-12">
        {!!Form::label('pac_motivo', 'Motivo')!!}
        {!!Form::textarea('pac_motivo', $pacientes->pac_motivo, ['class'=>'form-control'])!!}
      </div>


    <h2> Anamnesis</h2>

      <div class="form-group">
    {!! Form::Label('tipos', 'Tipo:') !!}
    {!! Form::select('tan_id', $tipos, $antecedentes->tan_id, ['class' => 'form-control']) !!}
    </div>


   <div class="col-lg-12">
        {!!Form::label('amg_descripcion', 'Descripcion:')!!}
        {!!Form::textarea('amg_descripcion', $antecedentes->amg_descripcion, ['class'=>'form-control'])!!}
      </div>




    <h2> Examen Intraoral</h2>

     <div class="col-lg-12">
        {!!Form::label('pac_observaciones', 'Observaciones')!!}
        {!!Form::textarea('pac_observaciones', $pacientes->pac_observaciones, ['class'=>'form-control'])!!}
      </div>

      <div class="form-horizontal">
        {!!Form::submit('Editar Paciente',['class'=>'btn btn-primary'])!!}
      </div>

<script type="text/javascript">


  $(function(){
      $("#rut").rut();
  }
  );
</script>


    {!!Form::close()!!}



@endsection
