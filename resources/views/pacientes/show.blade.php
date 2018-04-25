@extends('layouts.app')

@section('title','Ficha de Pacientes')


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

{!!Form::open(['route'=>['pacientes.show', $paciente], 'method' =>'POST', 'id'=>'pacientes_show' ,'name'=>'pacientes_show'])!!}
<div class="box box-primary">
  <div class="box-header">
    <h2> Ficha Dental del Paciente  {!!$paciente->pac_nombres!!} {!!$paciente->pac_apellido_paterno!!} </h2>
  </div>
  <div class ="box-body">
      <div class="col-lg-6">
        {!!Form::label('pac_nombres', 'Nombres Paciente')!!}
        {!!Form::text('pac_nombres', $paciente->pac_nombres, ['class'=>'form-control', 'readonly '=>"readonly"])!!}
      </div>

      <div class="col-lg-6">
        {!!Form::label('pac_apellido_paterno', 'Apellido Paterno')!!}
        {!!Form::text('pac_apellido_paterno', $paciente->pac_apellido_paterno, ['class'=>'form-control', 'readonly '=>"readonly"])!!}
      </div>

      <div class="col-lg-6">
        {!!Form::label('pac_apellido_materno', 'Apellido Materno')!!}
        {!!Form::text('pac_apellido_materno', $paciente->pac_apellido_materno, ['class'=>'form-control', 'readonly '=>"readonly"])!!}
      </div>

      <div class="col-lg-6">
        {!!Form::label('pac_rut_completo', 'Rut Paciente')!!}
        {!!Form::text('pac_rut_completo', $paciente->pac_rut_completo,  ['class'=>'form-control', 'id' => 'rut', 'readonly '=>"readonly"])!!}
      </div> 

      <div class="col-lg-6">
        {!!Form::label('pac_fecha_nacimiento', 'Fecha de Nacimiento')!!}
        {!!Form::date('pac_fecha_nacimiento', $paciente->pac_fecha_nacimiento,  ['class'=>'form-control', 'readonly '=>"readonly"])!!}

      </div>

      <div class="col-lg-6">
        {!!Form::label('pac_edad', 'Edad')!!}
        {!!Form::number('pac_edad', $paciente->pac_edad, ['class'=>'form-control', 'readonly '=>"readonly"])!!}
      </div>

      <div class="col-lg-6">
        {!!Form::label('pac_direccion', 'Direccion')!!}
        {!!Form::text('pac_direccion', $paciente->pac_direccion, ['class'=>'form-control', 'readonly '=>"readonly"])!!}
      </div>

      <div class="col-lg-6">
        {!!Form::label('com_id', 'Comuna de Residencia')!!}
        {!!Form::text('com_id', $comuna->com_nombre,['class'=>'form-control', 'readonly '=>"readonly"])!!}
      </div>

      <div class=" col-lg-6">
        {!!Form::label('pac_telefono', 'Teléfono')!!}
        {!!Form::text('pac_telefono', $paciente->pac_telefono, ['class'=>'form-control', 'readonly '=>"readonly"])!!}
      </div>

      <div class="col-lg-6">
        {!!Form::label('pac_email', 'Email Usuario')!!}
        {!!Form::text('pac_email', $paciente->pac_email, ['class'=>'form-control', 'readonly '=>"readonly"])!!}
      </div>

      <div class="col-lg-12">
        {!!Form::label('pac_motivo', 'Motivo')!!}
        {!!Form::textarea('pac_motivo', $paciente->pac_motivo, ['class'=>'form-control', 'readonly '=>"readonly", 'rows' => 4])!!}
      </div>
    </div>
</div>

<div class="box box-primary">
  <div class="box-header">
    <h2> Antecedentes Medicos Generales (Anamnesis)</h2>
  </div>
  <div class="box-body" id="antecedentes">
      @if(count($antecedentes) == 1)
        <div id = 'tipos'>
        <div class="col-lg-4">
          {!! Form::Label('tipos', 'Tipos:') !!}
          {!! Form::select('tan_id[]', $tipos, $antecedentes->tan_id, ['class' => 'form-control', 'placeholder'=> 'Seleccione Un Tipo', 'id ' => 'tan_id']) !!}
        </div>
        <div class="col-lg-7">
          {!!Form::label('amg_descripcion', 'Descripcion:')!!}
          {!!Form::text('amg_descripcion[]', $antecedentes->amg_descripcion, ['class'=>'form-control'])!!}
        </div>
      @elseif(count($antecedentes)>1)
      <div id = 'tipos'>
        @foreach($antecedentes as $antecedente)
         
            <div class="col-lg-4">
              @if($loop->first)
                {!! Form::Label('tipos', 'Tipos:') !!}
              @endif
              @if($antecedente->tan_id == 1)
                 {!! Form::text('tan_id[]', 'Enfermedades',  ['class' => 'form-control', 'id ' => 'tan_id', 'readonly '=>"readonly" ]) !!}
              @elseif($antecedente->tan_id == 2)
                 {!! Form::text('tan_id[]', 'Alergias',  ['class' => 'form-control', 'id ' => 'tan_id', 'readonly '=>"readonly" ]) !!}
              @elseif($antecedente->tan_id == 3)
                 {!! Form::text('tan_id[]', 'Medicamentos',  ['class' => 'form-control', 'id ' => 'tan_id', 'readonly '=>"readonly" ]) !!}
              @elseif($antecedente->tan_id == 4)
                 {!! Form::text('tan_id[]', 'Otros',  ['class' => 'form-control', 'id ' => 'tan_id', 'readonly '=>"readonly" ]) !!}
              @endif
            </div>
          <div class="col-lg-7">
            @if($loop->first)
              {!!Form::label('amg_descripcion', 'Descripcion:')!!}
            @endif
            {!!Form::text('amg_descripcion[]', $antecedente->amg_descripcion, ['class'=>'form-control', 'readonly '=>"readonly" ])!!}
          </div>
             
        @endforeach
        </div>
      @elseif(count($antecedentes) == 0)
           <h4 align="center">El paciente no presenta Antecedentes Medicos Generales</h4>
      @endif
     
      </div>    
</div>

<div class="box box-primary">
  <div class="box-header with-border">
    <h2> Examen Intraoral</h2>
  </div>
  <div class="box-body">
     <div class="col-lg-12">
        {!!Form::label('pac_observaciones', 'Observaciones')!!}
        {!!Form::textarea('pac_observaciones', $paciente->pac_observaciones, ['class'=>'form-control', 'rows' => 4, 'readonly'=> 'readonly'])!!}
      </div> 
    </div>
</div>

{!!Form::close()!!}
@endsection
