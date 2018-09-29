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
      $paciente = Pacientes::findOrFail($plan->pac_id);
      foreach ($sesiones as $sesion) {
		    $sesion->odontologo = Usuarios::findOrFail($sesion->usu_id);
       	} 
        
      return view('sesiones-ejecucion-tratamientos.index')->with('sesiones', $sesiones)->with('id', $pdt_id)->with('plan', $plan)->with('paciente', $paciente);

  	}
    
  	public function create($pdt_id)
  	{

  		$plan = PlanesDeTratamientos::findOrFail($pdt_id);
      if ($plan->ept_id >= 3) {
        return back()->withInput(['id', $pdt_id])->with('destroyStatus', '¡Este Plan esta completado o cancelado!');
      }
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
      
      
      $plan = PlanesdeTratamientos::findOrFail($pdt_id);
      if ($plan->ept_id == 3 || $plan->pdt_id == 4 || $plan->pdt_id == 5) {
            return redirect()->route('planes-de-tratamientos.pacienteindex', $pdt_id)->with('destroyStatus', '¡Este plan ya no puede tener mas sesiones!');
        }
        
        $sesion = new SesionesEjecucionTratamientos();
        $sesion->tra_id = $request->tratamiento_id;
        $sesion->pde_id = $request->pde_id;
        if (!$request->usu_id) {
            $sesion->usu_id = Auth::user()->usu_id;
        }else{
            $sesion->usu_id = $request->usu_id;
        }
        $sesion->set_fecha = date('Y-m-d');
        $sesion->set_hora = date('H:i');
        $sesion->set_descripcion_sesion = $request->set_descripcion_sesion;
        $sesion->pdt_id = $pdt_id;
        $sesion->save();
        if($plan->ept_id == 1){
          $plan->ept_id = 2;
          $plan->save();
        }
        
        if($request->mat_id){
          $set_id =  DB::table('sesiones_ejecucion_tratamientos')->where([['pdt_id', $pdt_id],
                                                        ['set_fecha' ,'=', $sesion->set_fecha ], 
                                                        ['usu_id', $sesion->usu_id]])->latest()->value('set_id');
        foreach ($request->mat_id as $k => $mat) {
          $material_sesion = New MaterialSesion();
          $material_sesion->set_id = $set_id;
          $material_sesion->mat_id = $mat;
          if($request->resta[$k] >= 0){
            $material_sesion->mse_cantidad = $request->resta[$k];
          }else{
             $material_sesion->mse_cantidad = 0;
          }
          
          $material_sesion->save();
          $material_arestar = Materiales::findOrFail($mat);
          $material_arestar->mat_stock = $material_arestar->mat_stock - $material_sesion->mse_cantidad;
          $material_arestar->save();

        }
      }
      return redirect()->route('sesiones-ejecucion-tratamientos.index', ['id' => $pdt_id])->with('status','¡Sesión creada con exito!');
       
    }

    public function destroy($id)
    {

      DB::table('material_sesion')->where('set_id', $id)->delete();

      $sesion = SesionesEjecucionTratamientos::findOrFail($id);
      $pdt_id = $sesion->pdt_id;
      $sesion->delete();
      return redirect()->route('sesiones-ejecucion-tratamientos.index', ['id' => $pdt_id])->with('destroyStatus','¡Sesión Eliminada con exito!');

    }

    public function show($id)
    {
      $sesion = SesionesEjecucionTratamientos::findOrFail($id);
      
      $plan = PlanesDeTratamientos::findOrFail($sesion->pdt_id);
      $plan->estado = EstadosPlanesDeTratamientos::findOrFail($plan->ept_id);
      $paciente = Pacientes::findOrFail($plan->pac_id);
      $paciente->pac_nombre_completo = $paciente->pac_nombres . ' ' . $paciente->pac_apellido_paterno . ' ' . $paciente->pac_apellido_materno;
      $paciente->pac_rut_completo = $paciente->pac_rut .'-'. $paciente->pac_dv;
      $plan_detalle = DB::table('plan_de_tratamiento_tratamiento')->where('pdt_id', $sesion->pdt_id)->get();
      foreach ($plan_detalle as $detalle) {
            $detalle->tratamiento = Tratamientos::findOrFail($detalle->tra_id);
            $tratamiento_aplicable[] = $detalle->tratamiento->tra_id;
            $detalle->piezas_seleccionadas = PiezasDentales::findOrFail($detalle->pde_id);
            $piezas_tratables[] = $detalle->piezas_seleccionadas->pde_id;
      }

        $odontologo = Usuarios::findOrFail($sesion->usu_id);
        
       $odontologo->usu_nombre_completo = $odontologo->usu_nombres . ' ' . $odontologo->usu_apellido_paterno . ' ' . $odontologo->usu_apellido_materno;

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
        $material_sesion = DB::table('material_sesion')->where('set_id', $sesion->set_id)->get();
        foreach ($material_sesion as $mat_set) {
          $mat_set->material = Materiales::findOrFail($mat_set->mat_id);
        }

        return view('sesiones-ejecucion-tratamientos.show')->with('sesion', $sesion)->with('id', $id)->with('paciente',$paciente)->with('odontologo', $odontologo)->with('antecedentes',$antecedentes)->with('material_sesion', $material_sesion)->with('plan', $plan)->with('plan_detalle', $plan_detalle);
        //return view('sesiones-ejecucion-tratamientos.create')->with('plan', $plan)->with('id', $plan->pdt_id)->with('materiales', $materiales)->with('plan_detalle', $plan_detalle)->with('odontologos', $odontologos)->with('antecedentes',$antecedentes)->with('tipos_antecedentes', $tipos_antecedentes)->with('paciente', $paciente)->with('tratamiento_aplicable', $tratamiento_aplicable)->with('piezas_tratables', $piezas_tratables);
      
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
                'resta' => $resta,
              );
              return \Response::json($response);
          }else{
            $response = array(
                'result'=>false,
                'msg' => 'No posee la cantidad seleccionada, ingresar cantidad menor',
              );
              return \Response::json($response);
          }
          
      }else{
        $response = array(
                'result'=>false,
                'msg' => 'Ha ocurrido un error inesperado, pruebe nuevamente',
               
              );
              return \Response::json($response);
      }

     

    }

    public function buscar_pieza(request $request)
    {

      //dd($request->all());
      if ($request->isMethod('post')) {
        $tra_id = $request->tra_id;
        $pdt_id = $request->pdt_id;
        $pde = DB::table('plan_de_tratamiento_tratamiento')->where([['pdt_id', $pdt_id], ['tra_id', $tra_id] ])->value('pde_id');
        //$pieza = DB::table('piezas_dentales')->where('pde_id', $pde)->get();
        $pieza = PiezasDentales::findOrFail($pde);
        
        if ($pieza) {
            $response = array(
                'result'=>true,
                'pieza_dental' => $pieza->pde_codigo_pieza,
                'pde_id' => $pde,
              );
              return \Response::json($response);
        }else{
            $response = array(
                'result'=>false,
                'msg' => 'Ha ocurrido un error inesperado, pruebe nuevamente',
               
              );
              return \Response::json($response);
        }
      }else{
        $response = array(
                'result'=>false,
                'msg' => 'Ha ocurrido un error inesperado, pruebe nuevamente',
               
              );
              return \Response::json($response);
      }


    }

}
