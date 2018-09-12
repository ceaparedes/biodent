@extends('layouts.app')

@section('title', 'Crear sesion de tratamiento')


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

{!!Form::open(['route'=>['sesiones-ejecucion-tratamientos.store', $plan->pdt_id], 'method' =>'POST', 'id'=>'sesiones_create' ,'name'=>'sesiones_create'])!!}
  <div class="box box-primary">
    <div class = "box-header">
      <h2>Sesión de Tratamiento: {{$paciente->pac_nombre_completo}}</h2>
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
    <div class="box-footer"></div>
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
          {!! Form::select('tan_id[]', $tipos_antecedentes, $antecedentes->tan_id, ['class' => 'form-control', 'placeholder'=> 'Seleccione Un Tipo', 'id ' => 'tan_id']) !!}
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
           <h4 align="center">El paciente no presenta Antecedentes Medicos Generales.</h4>
      @endif
      </div>    
</div>
<div class="box-footer"></div>


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
         <td >Costo Total:</td>
        <td> {!!Form::text('pdt_costo_total', number_format($plan->pdt_costo_total), ['class'=>'form-control', "readonly" =>"readonly", "id" => "costo_total"])!!}</td>
        
       </tfoot>
     </table>
    </div>
  </div>
  <div class="box-footer"></div>
</div>

<div class="box box-primary">
  <div class="box-header">
    <h3>Sesión a Realizar </h3>
  </div>
  <div class="box-body">
    <div class="col-lg-6">
      {!!Form::label('tra_id', 'Tratamiento')!!}
      {!!Form::select('tra_id', $tratamiento_aplicable, null , ['class'=>'form-control', 'placeholder'=> 'Seleccione'])!!}  
    </div>
    <div class="col-lg-6">
      {!!Form::label('pde_id', 'Pieza a tratar')!!}
      {!!Form::select('pde_id', $piezas_tratables, null , ['class'=>'form-control', 'placeholder'=>'Seleccione'])!!}
    </div>
    </div>
</div>

<div class="box box-primary">
  <div class="box-header">
    <h3>Materiales a Utilizar</h3>
  </div>
  <div class="box-body">
    <div class="col-lg-6">
      {!!Form::label('mat_id', 'Material:')!!}
      {!!Form::select('mat_id', $materiales, null , ['class'=>'form-control', 'placeholder'=>'Seleccione', 'id'=>'mat_id'])!!}
    </div>
    <div class="col-lg-4">
      {!!Form::label('mse_cantidad', 'Cantidad a Utilizar:')!!}
      {!!Form::number('mse_cantidad', null, ['class'=>'form-control', 'min'=>1 , 'id' =>'mse_cantidad'])!!}
    </div>
    <div class="col-lg-2">
        {!! Form::Label(' ', ' ') !!}
        {!! Form::Label(' ', ' ') !!}
        {!! Form::Label(' ', ' ') !!}
        {!!Form::button('<i class="fa fa-plus" aria-hidden="true"></i> Agregar',  ['class'=>'form-control btn btn-success', 'id'=> 'agregar'])!!}
      </div>
  </div>
  <div class="box-footer">
  </div>
</div>

<div class="box box-primary">
  <div class="box-header">
    <h3>Materiales utilizados</h3>
  </div>
  <div class="box-body">
   <div>
     <table class="table table-bordered table-hover dataTable" id="tabla-materiales">
       <thead>
         <th>Material</th>
         <th>Cantidad Utilizada</th>
         <th>Eliminar</th>
       </thead>
       <tbody id='tbody-materiales'>
         
       </tbody>
       <tfoot>
        
       </tfoot>
     </table>
    </div>
  </div>
  <div class="box-footer">
    <div class="form-horizontal" align="center">
          {!!Form::submit('Crear Sesión de Tratamiento',['class'=>'btn btn-success', 'id' => 'crear'])!!}
        </div>
  </div>
</div>
<script type="text/javascript">
   
$(document).ready(function(){

//añadir Tratamiento
   $('#agregar').on('click', function(){
    if (($('#mat_id').val() == null) || ($('#mse_cantidad').val() == null)) {
      alert('Debe seleccionar un Material y la cantidad a gastar');
      return false;
   }

   $.ajax({
            url: '/biodent/public/sesiones-ejecucion-tratamientos/consultar_stock',
            type: 'post',
            dataType: 'json',
            data: {
                    "_token": "{{ csrf_token() }}",
                    "id": $('#mat_id').val(),
                    "cantidad": $('#mse_cantidad').val(),
              },
            success: function(json){
              if(json.result){
                
                var html = '';
                 html += '<tr>';
                 html += '<td>'+json.material.mat_nombre_material+'</td>';
                 html += '<td>'+json.cantidad+'</td>';
                 html += '<td hidden="true"> <input type="hidden" id="mat_id" name ="mat_id[]" value ="'+json.material.mat_id+'"></td>';
                 html += '<td hidden ="true"> <input type="hidden" id="resta" name ="resta[]" value ="'+json.material.resta_stock+'"></td>';
                 html += '<td><button id="remove" name="remove" class="btn btn-danger pull-right" type="button" title ="Remover tratamientos"><i class="fa fa-times" aria-hidden="true"></i></button></td>';
                 html += '</tr>';
                $('#tbody-materiales').append(html);
 
              }else{
                $('#mse_cantidad').val('');
                alert(json.msg);
              }  
            }
        });

   
  });   

 });

 $(document).on('click', '#remove', function(){

   $(this).parent().parent().remove();

});





</script>

{!!Form::close()!!}



@endsection

