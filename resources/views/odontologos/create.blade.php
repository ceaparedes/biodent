@extends('layouts.app')

@section('title', 'Crear Odontologo')


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

  {!!Form::open(['route'=>'odontologos.store', 'method' =>'POST', 'id'=>'Odontologos_create' ,'name'=>'Odontologos_create'])!!}

 <div class = "box box-primary">
  <div class="box-header with-border">
  <h2> Crear Nuevo Odontologo</h2>
</div>
  
  <div class="box-body">
  	<div class="col-lg-6 col-xs-12">
        {!!Form::label('odo_nombres', 'Nombres Odontologo')!!}
        {!!Form::text('odo_nombres', null, ['class'=>'form-control'])!!}
    </div>

    <div class="col-lg-6 col-xs-12">
        {!!Form::label('odo_apellidos', 'Apellidos')!!}
        {!!Form::text('odo_apellidos', null, ['class'=>'form-control'])!!}
      </div>

    <div class="col-lg-6 col-xs-12">
        {!!Form::label('odo_rut_completo', 'Rut Odontologo')!!}
        {!!Form::text('odo_rut_completo', null, ['class'=>'form-control','id'=>'rut'])!!}
      </div> 

    <div class="col-lg-6 col-xs-12">
        {!!Form::label('odo_fecha_nacimiento', 'fecha de Nacimiento')!!}
        {!!Form::date('odo_fecha_nacimiento', null, ['class'=>'form-control'])!!}
      </div>

      <div class="col-lg-6 col-xs-12">
        {!!Form::label('odo_email', 'Correo Electrónico')!!}
        {!!Form::email('odo_email', null, ['class'=>'form-control'])!!}
      </div>

      <div class="col-lg-6 col-xs-12">
        {!!Form::label('odo_telefono', 'Teléfono')!!}
        {!!Form::number('odo_telefono', null, ['class'=>'form-control'])!!}
      </div>

      <div class="col-lg-12 col-xs-12">
        {!!Form::label('odo_direccion', 'Direccion')!!}
        {!!Form::text('odo_direccion', null, ['class'=>'form-control'])!!}
      </div>
    </div>
  </div>

  <div class = "box box-primary" >
     <div class = "box-header with-border"> 
      <h3>Especialidad(es) <button id="remove-all" name ="remove-all" class="btn btn-warning pull-right" type="button"><i class="fa fa-minus-circle" aria-hidden="true"></i></button> </h3>
     </div>
     <div class = 'box-body' id="especialidades">
      <div class ="col-lg-7">
       {!! Form::Label('especialidades', 'Especialidad:') !!}
       {!! Form::select('esp_id[]', $especialidades, null , ['id' => 'esp_id[]', 'class' => 'form-control ' , 'placeholder' =>'Seleccione Especialidad']) !!}
        </div>
        <button id="add" name="add" class="btn btn-success pull-right " type="button"><i class="fa fa-plus" aria-hidden="true"></i></button>
         
    </div>
  </div>
  
  <div class = "box box-success">
    <div class="box-header with-border">
      <h2>Información de Cuenta Usuario</h2> 
    </div> 

    <div class = 'box-body'>
      <div class="col-lg-6">
        {!!Form::label('odo_usuario', 'Usuario')!!}
        {!!Form::text('odo_usuario', null, ['class'=>'form-control'])!!}
      </div>

       <div class="col-lg-6">
        {!!Form::label('odo_rol', 'Rol Usuario')!!}
        {!!Form::select('odo_rol',['Usuario'=>'Usuario', 'Administrador'=>'Administrador'] , null, ['class'=>'form-control', 'placeholder' => 'Seleccione un Rol'])!!}
      </div>

      <div class="col-lg-6">
        {!!Form::label('odo_password', 'Contraseña')!!}
        {!!Form::password('odo_password', ['class'=>'form-control'])!!}
      </div>

      <div class="col-lg-6">
        {!!Form::label('odo_confirmar_password', 'Confirmar Contraseña')!!}
        {!!Form::password('odo_confirmar_password', ['class'=>'form-control'])!!}
      </div>

     

      <div class="form-horizontal col-lg-6 ">
        {!!Form::submit('Crear Odontologo',['class'=>'btn btn-success'])!!}
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
    var i = 1;
    $(document).on('click', '#add', function(){
      
      var html = '';
      html += '<div class ="col-lg-7"> {!!Form::select('esp_id[]', $especialidades, null, ['id' => 'esp_id[]', 'class' => 'form-control ' , 'placeholder' =>'Seleccione Especialidad'])!!}   </div>';
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