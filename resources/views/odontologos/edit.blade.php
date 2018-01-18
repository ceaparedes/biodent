@extends('layouts.app')

@section('title', 'Actualizar Odontologo')


@section('main-content')

@if (count($errors) > 0)
  <div class ="box box-danger">
    <div class="box box-body" >
      <div class="alert alert-danger">
          <ul>
              @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
              @endforeach
          </ul>
      </div>
      </div>
<div>
@endif

  {!!Form::open(['route'=>['odontologos.update',$odontologo], 'method' =>'PUT', 'id'=>'Odontologos_update' ,'name'=>'Odontologos_update'])!!}

<div class = "box box-primary">
  <div class="box-header with-border">
  <h2> Actualizar Información del Odontologo</h2>
</div>
  
<div class="box-body">
  	<div class="col-lg-6">
        {!!Form::label('odo_nombres', 'Nombres Odontologo')!!}
        {!!Form::text('odo_nombres', $odontologo->odo_nombres, ['class'=>'form-control'])!!}
    </div>

    <div class="col-lg-6">
        {!!Form::label('odo_apellidos', 'Apellidos')!!}
        {!!Form::text('odo_apellidos', $odontologo->odo_apellidos, ['class'=>'form-control'])!!}
      </div>

    <div class="col-lg-6">
        {!!Form::label('odo_rut_completo', 'Rut Odontologo')!!}
        {!!Form::text('odo_rut_completo', $odontologo->odo_rut_completo, ['class'=>'form-control','id'=>'rut'])!!}
      </div> 

    <div class="col-lg-6">
        {!!Form::label('odo_fecha_nacimiento', 'fecha de Nacimiento')!!}
        {!!Form::date('odo_fecha_nacimiento', $odontologo->odo_fecha_nacimiento, ['class'=>'form-control'])!!}
      </div>

      <div class="col-lg-6">
        {!!Form::label('odo_email', 'Correo Electrónico')!!}
        {!!Form::email('odo_email', $odontologo->odo_email, ['class'=>'form-control'])!!}
      </div>

      <div class=" col-lg-6">
        {!!Form::label('odo_telefono', 'Teléfono')!!}
        {!!Form::number('odo_telefono', $odontologo->odo_telefono, ['class'=>'form-control'])!!}
      </div>

      <div class="col-lg-12">
        {!!Form::label('odo_direccion', 'Direccion')!!}
        {!!Form::text('odo_direccion', $odontologo->odo_direccion, ['class'=>'form-control'])!!}
      </div>
</div>
</div>

    <div class = "box box-primary" >
     <div class = "box-header with-border"> 
      <h3>Especialidad(es) <button id="remove-all" name ="remove-all" class="btn btn-warning pull-right" type="button"><i class="fa fa-minus-circle" aria-hidden="true"></i></button></h3>
     </div>

     <div class = 'box-body' id="especialidades">
      @if(count($especialidades) == 1)
         <div class ="col-lg-7">
       {!! Form::Label('especialidades', 'Especialidad:') !!}
       @if($especialidades->esp_id != null)
          {!! Form::select('esp_id[]', $esp, $especialidades->esp_id , ['id' => 'esp_id[]', 'class' => 'form-control ' , 'placeholder' =>'Seleccione Especialidad']) !!}
       @else
          
          {!! Form::select('esp_id[]', $esp, null , ['id' => 'esp_id[]', 'class' => 'form-control ' , 'placeholder' =>'Seleccione Especialidad']) !!}
        @endif
        </div>
        <button id="add" name="add" class="btn btn-success pull-right " type="button"><i class="fa fa-plus" aria-hidden="true"></i></button>

      @elseif(count($especialidades)>1)
        @foreach($especialidades as $especialidad)
          <div class ="col-lg-7">
            @if($loop->first)
              {!! Form::Label('especialidades', 'Especialidad:') !!}
            @endif
         {!! Form::select('esp_id[]', $esp, $especialidad->esp_id , ['id' => 'esp_id[]', 'class' => 'form-control' , 'placeholder' =>'Seleccione Especialidad']) !!}
         </div>
         @if ($loop->first)
           <button id='add' name="add" class="btn btn-success pull-right" type="button"><b><i class="fa fa-plus" aria-hidden="true"></i></b></button>
          @else
          <button id='remove' name="remove" class="btn btn-danger pull-right" type="button"><i class="fa fa-minus" aria-hidden="true"></i></button>
         @endif
         
        @endforeach
      @endif
    </div>
  </div>

  <div class = "box box-success">
    <div class="box-header with-border">
      <h2>Información de Cuenta Usuario</h2> 
    </div> 

    <div class = 'box-body'>
       <div class="col-lg-6">
        {!!Form::label('odo_usuario', 'Usuario')!!}
        {!!Form::text('odo_usuario', $odontologo->odo_usuario, ['class'=>'form-control'])!!}
      </div>

      <div class="col-lg-6">
        {!!Form::label('odo_rol', 'Rol Usuario')!!}
        {!!Form::select('odo_rol',['Usuario' => 'Usuario', 'Administrador'=>'Administrador'] , $odontologo->odo_rol, ['class'=>'form-control', 'placeholder' => 'Seleccione un Rol'])!!}
      </div>

      <div class="col-lg-6">
        {!!Form::label('odo_password', 'Contraseña')!!}
        {!!Form::password('odo_password',  ['class'=>'form-control'])!!}
      </div>

      <div class="col-lg-6">
        {!!Form::label('odo_confirmar_password', 'Confirmar Contraseña')!!}
        {!!Form::password('odo_confirmar_password',  ['class'=>'form-control'])!!}
      </div>

      <div class="form-horizontal col-lg-6 ">
        {!!Form::submit('Actualizar Odontologo',['class'=>'btn btn-primary'])!!}
      </div>
      </div>
    </div>
      
<!--funcion validadora rut -->
<script type="text/javascript">

  $(function(){
      $("#rut").rut();
  }
  );
</script>

<!--funcion js para añadir input dinamicamente-->
<script type="text/javascript">
  
  $(document).ready(function(){
    var i = $('#especialidades select').length;
    $(document).on('click', '#add', function(){
      
      var html = '';
      html += '<div class ="col-lg-7"> {!!Form::select('esp_id[]', $esp, null, ['id' => 'esp_id[]', 'class' => 'form-control ' , 'placeholder' =>'Seleccione Especialidad'])!!}   </div>';
      html += '<button id="remove" name="remove" class="btn btn-danger pull-right" type="button"><i class="fa fa-minus" aria-hidden="true"></i></button> '; 
      
      if (i <= 3) {
        $('#especialidades').append(html);
        i++;

        }

    });

    $(document).on('click', '#remove', function(){
        i--;
        $(this).prev('div').remove();
        $(this).remove();
        
    });

    $(document).on('click', '#remove-all', function(){
      i=1;
      //vaciar todos los elementos del box especialidades
      $('#especialidades').empty();
      //añadir los elementos de un especialidad nuevamente
      var html_all = '';
      html_all +='<div class ="col-lg-7">';
      html_all +='{!! Form::Label('especialidades', 'Especialidad:') !!}';
      html_all +='{!! Form::select('esp_id[]', $especialidades, null , ['id' => 'esp_id[]', 'class' => 'form-control ' , 'placeholder' =>'Seleccione Especialidad']) !!} </div>';
      html_all += '<button id="add" name="add" class="btn btn-success pull-right " type="button"><i class="fa fa-plus" aria-hidden="true"></i></button>';

      $('#especialidades').append(html_all);

    });
  });

</script>


{!!Form::close()!!}


@endsection