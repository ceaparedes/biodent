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

{!!Form::open(['route'=>['planes-de-tratamientos.store', $paciente], 'method' =>'POST', 'id'=>'tratamientos_create' ,'name'=>'tratamientos_create'])!!}
  <div class="box box-primary">
    <div class = "box-header">
      <h2>Creacion de Plan de Tratamiento</h2>
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

<div class="box box-primary">
  <div class="box-header">
    <h3>Tratamientos  para el Paciente </h3>
  </div>
  <div class="box-body" id='plan-de-tratamiento'>
  <div id = "listado_tratamientos">
    <div class="col-lg-6">
          {!! Form::Label('tra_nombre', 'Tratamientos:') !!}
          {!! Form::select('tratamientos', $nombres_tratamientos,  NULL, ['class' => 'form-control', 'placeholder'=> 'Seleccione Un Tratamiento', 'id ' => 'tratamientos']) !!}
    </div>

    <div class="col-lg-4">
          {!! Form::Label('pde_codigo_pieza', 'Piezas a tratar:') !!}
          {!! Form::select('piezas_dentales', $pieza_dental, NULL, ['class' => 'form-control', 'placeholder'=> 'Seleccione Una Pieza', 'id ' => 'piezas_dentales']) !!}
    </div>

    <div class="col-lg-2">
        {!! Form::Label(' ', ' ') !!}
        {!!Form::button('<i class="fa fa-search" aria-hidden="true"></i> Buscar',  ['class'=>'form-control btn btn-primary', 'id'=> 'buscar'])!!}
      </div>

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
         <th>Eliminar</th>
       </thead>
       <tbody id='tbody-plan'>
         
       </tbody>
       <tfoot>
         <td> </td>
         <td class="pull-right">Costo Total:</td>
        <td> {!!Form::number('pdt_costo_total', 0, ['class'=>'form-control', "readonly" =>"readonly", "id" => "costo_total"])!!}</td>
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
    @if(Auth::user()->usu_rol != 'Administrador')
    <div class="col-lg-6" >
        {!! Form::Label('usu_id', 'Odontologo creador de Plan:') !!}
        {!! Form::select('usu_id', $odontologos, Auth::user()->usu_id, ['class' => 'form-control', 'placeholder'=> 'Seleccione..', 'id ' => 'usu_id', 'disabled' => true]) !!}
    </div>
    @else
    <div class="col-lg-6" >
        {!! Form::Label('usu_id', 'Odontologo creador de Plan:') !!}
        {!! Form::select('usu_id', $odontologos, null, ['class' => 'form-control', 'placeholder'=> 'Seleccione..', 'id ' => 'usu_id']) !!}
    </div>

    @endif
  </div>
  <div class="box-footer">
    <div class="form-horizontal" align="center">
          {!!Form::submit('Crear Plan de Tratamiento',['class'=>'btn btn-success', 'id' => 'crear'])!!}
        </div>
  </div>
</div>




<script type="text/javascript">
var id_tratamiento;
var tratamiento_seleccionado;
var pieza_dental;
var costo;
var costo_total = 0;
var costos_tratamientos = <?php echo $costos_tratamientos?>;
var sumar_tratamiento = false;
var restar_tratamiento = false; 
var i = 0;
$(document).ready(function(){

//añadir Tratamiento
  $('#buscar').on('click', function(){
    if (($('#tratamientos').val() == null) || ($('#piezas_dentales').val() == null)) {
      alert('Debe seleccionar un Tratamiento y una pieza dental');
      return false;
   }
   

   tratamiento_seleccionado = $("#tratamientos option:selected").text();
   pieza_dental = $("#piezas_dentales option:selected").text();
   id_tratamiento =  $("#tratamientos option:selected").val();
   id_pieza = $("#piezas_dentales option:selected").val();
   costo = costos_tratamientos[id_tratamiento];
   
   var html = '';
   html += '<tr>';
   html += '<td>'+tratamiento_seleccionado+'</td>';
   html += '<td>'+pieza_dental+'</td>';
   html += '<td>'+costo+'</td>';
   html += '<td hidden="true"> <input type="hidden" id="tra_id" name ="tra_id[]" value ="'+id_tratamiento+'"></td>';
   html += '<td hidden ="true"> <input type="hidden" id="pde_id" name ="pde_id[]" value ="'+id_pieza+'"></td>';
   html += '<td><button id="remove" name="remove" class="btn btn-danger pull-right" type="button" title ="Remover tratamientos"><i class="fa fa-times" aria-hidden="true"></i></button></td>';
   html += '</tr>';

   $('#tbody-plan').append(html);
   i++;

   costo_total = costo_total + parseInt(costo);
   document.getElementById('costo_total').value = costo_total;
   sumar_tratamiento = true;
   
  });   

 });
//eliminar tratamiento
  $(document).on('click', '#remove', function(){
    var costo_a_restar = $(this).closest('td').prev('td').prev('td').prev('td').text();
    var elemento_eliminado = $(this).closest('td').prev('td').prev('td').prev('td').prev('td').text();
     if (sumar_tratamiento) {
        costo_total = costo_total - parseInt(costo_a_restar);
        document.getElementById('costo_total').value = costo_total;
     }else{
        document.getElementById('costo_total').value = 0;
     }       
     $(this).parent().parent().remove();

      i--;
    });
//Enviar Documento;

$(document).on('click','#crear', function(){

  if(i<=0){
    alert('Debe Ingresar como mínimo un tratamiento y pieza dental');
    return false;
  }

  //return false;
  

});


  




</script>

{!!Form::close()!!}



@endsection
