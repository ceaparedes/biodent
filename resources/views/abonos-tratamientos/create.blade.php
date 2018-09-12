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

{!!Form::open(['route'=>['sesiones-ejecucion-tratamientos-tratamientos.store', $id], 'method' =>'POST', 'id'=>'abono_create' ,'name'=>'abono_create'])!!}
  <div class="box box-primary">
    <div class = "box-header">
      <h2>Creacion de Sesion de Tratamiento</h2>
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

    </div>
    <div class="box-footer">  
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
         <td>Costo Total: </td>
        <td> {!!Form::text('pdt_costo_total', number_format($plan->pdt_costo_total), ['class'=>'form-control', "readonly" =>"readonly", "id" => "costo_total"])!!}</td>

       </tfoot>
     </table>
    </div>
  </div>
  <div class="box-footer">
       
  </div>
</div>

<div class="box box-primary">
  <div class="box-header">
    <h3>Abonos realizados anteriormente</h3>
  </div>
  <div class="box-body">
    @if($abonos_anteriores)
      @foreach($abonos_anteriores as $aux)
      <div class="col-lg-6">
        {!!Form::label('abt_fecha','Fecha Abono:')!!}
        {!!Form::date('abt_fecha', $aux->abt_fecha, ['class'=> 'form-control', 'disabled'=>true])!!}
      </div>
      <div class="col-lg-6">
        {!!Form::label('abt_monto_abonado', 'Monto Anterior Abonado')!!}
        {!!Form::text('abt_monto_abonado', number_format($aux->abt_monto_abonado), ['class'=>'form-control', 'disabled'=>true])!!}
      </div>
      @endforeach
    @else
      <h3> No existen abonos anteriores</h3>
    @endif
    </div>
</div>

<div class="box box-primary">
  <div class="box-body">
  <div class="col-lg-6" >
        {!! Form::Label('abt_monto_abonado', 'Monto a cancelar:') !!}
        {!! Form::number('abt_monto_abonado', null , ['class' => 'form-control', 'id ' => 'abt_monto_abonado','min'=>'1']) !!}
    </div>
  </div>
  <div class="box-footer">
    <div class="form-horizontal" align="center">
          {!!Form::submit('Crear Plan de Tratamiento',['class'=>'btn btn-success', 'id' => 'crear'])!!}
        </div>
  </div>
</div>


{!!Form::close()!!}



@endsection
