@extends('layouts.app')

@section('title', 'Crear Tratamiento')


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

{!!Form::open(['route'=>['planes-de-tratamientos.show', $plan], 'method' =>'PUT', 'id'=>'tratamientos_update' ,'name'=>'tratamientos_update'])!!}
  <div class="box box-primary">
    <div class = "box-header">
      <h2>Plan de Tratamiento: {{$paciente->pac_nombre_completo}} 
        @if($plan->ept_id < 3)
        <a class="btn btn-danger pull-right" href="{{route('planes-de-tratamientos.cancelar_plan', $plan->pdt_id)}}">Cancelar plan </a> 
        <a class="btn btn-primary pull-right" href="{{route('planes-de-tratamientos.finalizar_plan', $plan->pdt_id)}}">Finalizar Plan</a>  

        @endif
        <a class="btn btn-success pull-right" href="{{route('planes-de-tratamientos.generar_pdf', $plan->pdt_id)}}">Generar Documento </a> 
      </h2>
      <h3>Información del Paciente</h3>
    </div>
    <div class="box-body">
      <div class="col-lg-6">
        {!!Form::label('pac_nombre_completo', 'Nombre Paciente')!!}
        {!!Form::text('pac_nombre_completo', $paciente->pac_nombre_completo, ['class'=>'form-control', 'readonly'=>'readonly'])!!}
      </div>

      <div class="col-lg-6">
        {!!Form::label('pac_rut_completo', 'RUT Paciente')!!}
        {!!Form::text('pac_rut_completo', $paciente->pac_rut_completo, ['class'=>'form-control', 'readonly' => 'readonly'])!!}
      </div>

      <div class="col-lg-12">
        {!!Form::label('pac_motivo', 'Motivo')!!}
        {!!Form::textarea('pac_motivo', $paciente->pac_motivo, ['class'=>'form-control', 'rows' => 4, 'readonly' => 'readonly'])!!}
      </div>
      <h3>Examen Intraoral</h3>
      <div class="col-lg-12">
        {!!Form::label('pac_observaciones', 'Observaciones')!!}
        {!!Form::textarea('pac_observaciones', $paciente->pac_observaciones, ['class'=>'form-control', 'rows' => 4, 'readonly' => 'readonly'])!!}
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
           @if($antecedentes->tan_id == 1)
                 {!! Form::text('tan_id[]', 'Enfermedades',  ['class' => 'form-control', 'id ' => 'tan_id', 'readonly '=>"readonly" ]) !!}
              @elseif($antecedentes->tan_id == 2)
                 {!! Form::text('tan_id[]', 'Alergias',  ['class' => 'form-control', 'id ' => 'tan_id', 'readonly '=>"readonly" ]) !!}
              @elseif($antecedentes->tan_id == 3)
                 {!! Form::text('tan_id[]', 'Medicamentos',  ['class' => 'form-control', 'id ' => 'tan_id', 'readonly '=>"readonly" ]) !!}
              @elseif($antecedentes->tan_id == 4)
                 {!! Form::text('tan_id[]', 'Otros',  ['class' => 'form-control', 'id ' => 'tan_id', 'readonly '=>"readonly" ]) !!}
              @endif
        </div>
        <div class="col-lg-7">
          {!!Form::label('amg_descripcion', 'Descripcion:')!!}
          {!!Form::text('amg_descripcion[]', $antecedentes->amg_descripcion, ['class'=>'form-control', 'readonly' => true])!!}
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
           <h4 align="center">El paciente no presenta Antecedentes Medicos Generales.</h4>
      @endif
      </div>    
</div>
</div>

<div class="box box-primary">
  <div class="box-body">
    <div>
     <table class="table table-bordered table-hover dataTable" id="tabla-plan">
       <thead>
         <th>Tratamiento</th>
         <th>Pieza dental</th>
         <th>Costo</th>
       </thead>
       <tbody id='tbody-plan'>
        @if($plan_detalle)
         @foreach($plan_detalle as $aux)
         <tr>
           <td>{{$aux->tratamiento->tra_nombre}}</td>
           <td>{{$aux->piezas_seleccionadas->pde_codigo_pieza}}</td>
           <td>{{number_format($aux->tratamiento->tra_costo)}}</td>
           <td hidden="true"> <input type="hidden" id="tra_id" name ="tra_id[]" value ="{{$aux->tra_id}}"></td>
           <td hidden="true"> <input type="hidden" id="pde_id" name ="pde_id[]" value ="{{$aux->pde_id}}"></td>
         </tr>
         @endforeach
         @endif
       </tbody>
       <tfoot>
         <td> </td>
         <td class="pull-right">Costo Total:</td>
        <td> {!!Form::text('pdt_costo_total', number_format($plan->pdt_costo_total), ['class'=>'form-control', "readonly" =>"readonly", "id" => "costo_total"])!!}</td>
        <td></td>
       </tfoot>
     </table>
    </div>
  </div>
  <div class="box-footer">
       
  </div>
</div>

<div class="box box-primary">
  <div class="box-body">
    @if(Auth::user()->usu_rol != 'Odontologo')
    <div class="col-lg-6" >
        {!! Form::Label('usu_id', 'Odontologo creador de Plan:') !!}
        {!! Form::select('usu_id', $odontologos, $plan->usu_id, ['class' => 'form-control', 'placeholder'=> 'Seleccione..', 'id ' => 'usu_id', 'disabled' => true]) !!}
    </div>
    @else
    <div class="col-lg-6" >
        {!! Form::Label('usu_id', 'Odontologo creador de Plan:') !!}
        {!! Form::select('usu_id', $odontologos, Auth::user()->usu_id, ['class' => 'form-control', 'placeholder'=> 'Seleccione..', 'id ' => 'usu_id', 'disabled' => true]) !!}
    </div>

    @endif
    <div class="col-lg-6">
      {!! Form::Label('ept_id', 'Estado plan:') !!}
      {!! Form::text('usu_id', $plan->estado->ept_estado, ['class' => 'form-control', 'readonly' => true]) !!}
    </div>
  </div>
  <div class="box-footer">
     
  </div>
</div>



{!!Form::close()!!}



@endsection
