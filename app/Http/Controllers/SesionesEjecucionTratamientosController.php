<?php

namespace App\Http\Controllers;

//use Models
use App\SesionesEjecucionTratamientos;
use App\PlanesdeTratamientos;
use App\Pacientes;
use App\Materiales;
use App\MaterialSesion;
use App\Usuarios;
use App\EstadosPlanesDeTratamientos;
use App\PlandeTratamientoTratamiento;
use App\Tratamientos;
use App\PiezasDentales;
use App\AntecedentesMedicosGenerales;
use App\TiposAntecedentes;

//Use tools
use Malahierba\ChileRut\ChileRut;
use Illuminate\Http\Request;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

use Auth;

class SesionesEjecucionTratamientosController extends Controller
{
   
	public function __construct()
  	{
      $this->middleware('auth');
  	}

  	public function index($pdt_id)
  	{
  		
  		$plan = PlanesDeTratamientos::findOrFail($pdt_id);
  		$plan->estado = EstadosPlanesDeTratamientos::findOrFail($plan->ept_id);
       	$sesiones =  SesionesEjecucionTratamientos::where('pdt_id', $pdt_id)->orderBy('pdt_id','ASC')->paginate(10);
       	$sesion->paciente = Pacientes::findOrFail($plan->pac_id);
       	foreach ($sesiones as $sesion) {
		    $sesion->odontologo = Usuarios::findOrFail($sesion->usu_id);
       	} 
        
        return view('sesiones-ejecucion-tratamientos.index')->with('planes', $planes)->with('id', $pdt_id);

  	}

  	public function create($pdt_id)
  	{

  		$plan = PlanesDeTratamientos::findOrFail($pdt_id);
  		$plan->estado = EstadosPlanesDeTratamientos::findOrFail($plan->ept_id);
  		$paciente = Pacientes::findOrFail($plan->pac_id);
      $paciente->pac_nombre_completo = $paciente->pac_nombres . ' ' . $paciente->pac_apellido_paterno . ' ' . $paciente->pac_apellido_materno;
      $paciente->pac_rut_completo = $paciente->pac_rut .'-'. $paciente->pac_dv;
      $plan_detalle = DB::table('plan_de_tratamiento_tratamiento')->where('pdt_id', $pdt_id)->get();
      foreach ($plan_detalle as $detalle) {
            $detalle->tratamiento = Tratamientos::findOrFail($detalle->tra_id);
            $tratamiento_aplicable[] = $detalle->tratamiento->tra_id;
            $detalle->piezas_seleccionadas = PiezasDentales::findOrFail($detalle->pde_id);
            $piezas_tratables[] = $detalle->piezas_seleccionadas->pde_id;
      }

      $odontologos = Usuarios::where('usu_rol', '!=', 'Asistente')->get();
        foreach ($odontologos as $aux) {
            $aux->usu_nombre_completo = $aux->usu_nombres . ' '. $aux->usu_apellido_paterno . ' '. $aux->usu_apellido_materno;
        }
        $odontologos = $odontologos->pluck('usu_nombre_completo', 'usu_id');

        $amg_id = DB::table('antecedentes_medicos_generales')->where('pac_id', $plan->pac_id)->pluck('amg_id');
        //se cuenta la cantidad de antecedentes.
        $c = count($amg_id);
        if ($c == 1) {
          //si es un solo antecedente, trae la informacion del antecedente en cuestion
          $antecedentes = AntecedentesMedicosGenerales::findOrFail($amg_id[0]);
        }
        elseif ($c > 1) {
          $i= 0;
          while($i != $c){
            $antecedentes[$i] = AntecedentesMedicosGenerales::findOrFail($amg_id[$i]);
            $i++;
          }
        }
        else{
          //en caso de que no existan antecedentes 
          $antecedentes = NULL;
        }
        $tipos_antecedentes = TiposAntecedentes::pluck('tan_tipo', 'tan_id');
        
        $tratamiento_aplicable = Tratamientos::whereIn('tra_id', $tratamiento_aplicable)->pluck('tra_nombre', 'tra_id');
        $piezas_tratables = PiezasDentales::whereIn('pde_id', $piezas_tratables)->pluck('pde_codigo_pieza', 'pde_id');
        
  		$materiales = Materiales::pluck('mat_nombre_material','mat_id');

  		return view('sesiones-ejecucion-tratamientos.create')->with('plan', $plan)->with('id', $pdt_id)->with('materiales', $materiales)->with('plan_detalle', $plan_detalle)->with('odontologos', $odontologos)->with('antecedentes',$antecedentes)->with('tipos_antecedentes', $tipos_antecedentes)->with('paciente', $paciente)->with('tratamiento_aplicable', $tratamiento_aplicable)->with('piezas_tratables', $piezas_tratables);
  	}

    public function store(request $request, $pdt_id)
    {

      dd($request);



    }

    public function consultar_stock(request $request)
    {
      if($request->isMethod('post')){
          $mat_id = $request->id;
          $cantidad = $request->cantidad;
          $material_seleccionado = Materiales::findOrFail($mat_id);
          $resta = $material_seleccionado->mat_stock - $cantidad;
          if($resta >= 0){
              $response = array(
                'result'=>true,
                'msg' => 'material agregado',
                'material' => $material_seleccionado,
                'cantidad' => $cantidad,
                'resta_stock' => $resta,
              );
              return \Response::json($response);
          }else{
            $response = array(
                'result'=>false,
                'msg' => 'No posee la cantidad seleccionada, ingresar valor menor',
               
              );
              return \Response::json($response);
          }
          
      }

      echo "1";die;

    }

}
