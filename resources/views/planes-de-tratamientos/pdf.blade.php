<!DOCTYPE html>
<html>
<head>
	<title>Presupuesto Paciente</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<!--<link href="/css/bootstrap.css" rel="stylesheet" type="text/css" />
	<link href="/css/AdminLTE.css" rel="stylesheet" type="text/css" />-->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<style type="text/css">
		body {
		  -webkit-font-smoothing: antialiased;
		  -moz-osx-font-smoothing: grayscale;
		  font-family: 'Source Sans Pro', 'Helvetica Neue', Helvetica, Arial, sans-serif;
		  font-weight: 400;
		  overflow-x: hidden;
		  overflow-y: auto;
		}
		tr:hover {background-color: #f5f5f5;}
		
	</style>	
</head>
<body>
	<div id="info-header">
	<h1 text align="center">Presupuesto paciente</h1>
</div>
<div class="box box-primary">
	<div class="box-header">
		<h2> Información del Paciente</h2>
	</div>
	<div class="box-body">
		<div class="col-lg-6">
			<label>Nombre Paciente: </label>{{$plan->paciente->pac_nombre_completo}}
		</div>
		<div class="col-lg-6">
			<label>Rut Paciente:</label>{{$plan->paciente->pac_rut_completo}}
		</div>

		<div class="col-lg-12">
			<label> Motivo:</label>
			{{$plan->paciente->pac_motivo}}
		</div>
		<div class="col-lg-12">
			<label> Observaciones:</label>
			{{$plan->paciente->pac_observaciones}}
		</div>
	</div>
</div>

<div class="box box-primary">
	<div class="box-header">
		<h2> Plan de Tratamiento:</h2>
	</div>
	<div class="box-body">
		<table class="table " id="tabla-plan">
       <thead>
         <th>Tratamiento</th>
         <th>Pieza dental</th>
         <th>Costo</th>
       </thead>
       <tbody id='tbody-plan'>
        @if($detalle)
         @foreach($detalle as $aux)
         <tr>
           <td>{{$aux->tratamiento->tra_nombre}}</td>
           <td>{{$aux->piezas_seleccionadas->pde_codigo_pieza}}</td>
           <td>{{number_format($aux->tratamiento->tra_costo)}}</td>
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
</div>
<div>Fecha Emisión presupuesto: {{date('d-m-Y')}}</div>
</body>
</html>