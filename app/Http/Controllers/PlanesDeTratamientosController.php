<?php

namespace App\Http\Controllers;

//use models
use App\PlanesDeTratamientos;
use App\Pacientes;
use App\AntecedentesMedicosGenerales;
use App\TiposAntecedentes;
use App\Usuarios;
use App\Tratamientos;
use App\PiezasDentales;
use App\PlandeTratamientoTratamiento;
use App\EstadosPlanesDeTratamientos;
use App\AbonosTratamientos;

//use Laravel Tools
use Illuminate\Http\Request;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;

class PlanesDeTratamientosController extends Controller
{

	public function __construct()
  	{
      	$this->middleware('auth');
  	}

	public function index()
	{

        if (auth::user()->usu_rol != 'Odontologo') {
          $planes = PlanesDeTratamientos::orderBy('pdt_id','ASC')->paginate(10);
          foreach ($planes  as $plan) {
              $plan->paciente = Pacientes::findOrFail($plan->pac_id);
              $plan->odontologo = Usuarios::findOrFail($plan->usu_id);
              $plan->estado = EstadosPlanesDeTratamientos::findOrFail($plan->ept_id);
              $plan->abonos = AbonosTratamientos::where('pdt_id', $plan->pdt_id)->count();

          }
          
           return view('planes-de-tratamientos.index')->with('planes', $planes);

        }else{

          return back()->with('destroyStatus', 'No tiene los permisos Necesarios para acceder a esa función');
        }

	}

    public function pacienteindex($pac_id)
    {
        $planes = PlanesDeTratamientos::where('pac_id', $pac_id)->orderBy('pdt_id','DESC')->paginate(10);
        foreach ($planes  as $plan) {
          $plan->paciente = Pacientes::findOrFail($plan->pac_id);
          $plan->odontologo = Usuarios::findOrFail($plan->usu_id);
          $plan->estado = EstadosPlanesDeTratamientos::findOrFail($plan->ept_id);
          $plan->abonos = AbonosTratamientos::where('pdt_id', $plan->pdt_id)->count();
        }
        
        return view('planes-de-tratamientos.pacienteindex')->with('planes', $planes)->with('id',$pac_id);
       

    }

    public function create($pac_id)
    {
    	//nuevo Plan de Tratamientos
    	$plan = new PlanesDeTratamientos();
    	//información del paciente
    	$paciente = Pacientes::findOrFail($pac_id);
    	$paciente->pac_rut_completo = $paciente->pac_rut . '-' . $paciente->pac_dv;
    	$paciente->pac_nombre_completo = $paciente->pac_nombres . ' ' . $paciente->pac_apellido_paterno . ' ' . $paciente->pac_apellido_materno;
    	//listado de Tratamientos
    	$nombres_tratamientos = Tratamientos::pluck('tra_nombre', 'tra_id');
    	$costos_tratamientos = Tratamientos::pluck('tra_costo', 'tra_id');
    	//listado de odontologos
        $odontologos = Usuarios::where('usu_rol', '!=', 2)->get();
        foreach ($odontologos as $aux) {
            $aux->usu_nombre_completo = $aux->usu_nombres . ' '. $aux->usu_apellido_paterno . ' '. $aux->usu_apellido_materno;
        }
        $odontologos = $odontologos->pluck('usu_nombre_completo', 'usu_id');
        
    	//listado de Piezas dentales
    	$pieza_dental = PiezasDentales::pluck('pde_codigo_pieza', 'pde_id');
    	$amg_id = DB::table('antecedentes_medicos_generales')->where('pac_id', $pac_id)->pluck('amg_id');
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

	    return view('planes-de-tratamientos.create')->with('plan',$plan)->with('paciente', $paciente)->with('costos_tratamientos', $costos_tratamientos)->with('pieza_dental', $pieza_dental)->with('antecedentes', $antecedentes)->with('tipos_antecedentes', $tipos_antecedentes)->with('nombres_tratamientos', $nombres_tratamientos)->with('odontologos', $odontologos);

    }

    public function store($pac_id, request $request)
    {
    	
        
    	$paciente = Pacientes::findOrFail($pac_id);
        $plan = new PlanesDeTratamientos();
        $plan->pdt_fecha_inicio =  date('Y-m-d');
        $plan->pdt_costo_total = $request->pdt_costo_total;
        $plan->pac_id = $pac_id;
        if (!$request->usu_id) {
            $plan->usu_id = Auth::user()->usu_id;
        }else{
            $plan->usu_id = $request->usu_id;
        }
        
        $plan->ept_id = 1;
        $plan->save();
        $paciente->pac_observaciones = $request->pac_observaciones;
        $paciente->pac_motivo = $request->pac_motivo;   
        $paciente->save();

         $pdt_id =  DB::table('planes_de_tratamientos')->where([['pac_id', $pac_id],
                                                        ['pdt_fecha_inicio' ,'=', $plan->pdt_fecha_inicio ], 
                                                        ['usu_id', $plan->usu_id]])->latest()->value('pdt_id');

        $c = count($request->tra_id);
        $i = 0;
        while($i < $c){
            $plan_de_tratamiento = new PlandeTratamientoTratamiento();
            $plan_de_tratamiento->pdt_id = $pdt_id;
            $plan_de_tratamiento->pde_id = $request->pde_id[$i];
            $plan_de_tratamiento->tra_id = $request->tra_id[$i];
            $plan_de_tratamiento->save();

            $i++;
        }
        return redirect('planes-de-tratamientos')->with('status', '¡Plan creado con exito!');
        //falta redirect
    }

    public function edit($id)
    {
       
        $plan = PlanesDeTratamientos::findOrFail($id);
        
        if ($plan->ept_id != 1) {
            return redirect('planes-de-tratamientos')->with('destroyStatus', '¡Ya no se Puede Modificar Plan!');
        }
        //información del paciente
        $paciente = Pacientes::findOrFail($plan->pac_id);

        $paciente->pac_rut_completo = $paciente->pac_rut . '-' . $paciente->pac_dv;
        $paciente->pac_nombre_completo = $paciente->pac_nombres . ' ' . $paciente->pac_apellido_paterno . ' ' . $paciente->pac_apellido_materno;
        //listado de Tratamientos
        $nombres_tratamientos = Tratamientos::pluck('tra_nombre', 'tra_id');
        $costos_tratamientos = Tratamientos::pluck('tra_costo', 'tra_id');
        
        $plan_detalle = DB::table('plan_de_tratamiento_tratamiento')->where('pdt_id', $plan->pdt_id)->get();

        $odontologos = Usuarios::where('usu_rol', '!=', 2)->get();
        foreach ($odontologos as $aux) {
            $aux->usu_nombre_completo = $aux->usu_nombres . ' '. $aux->usu_apellido_paterno . ' '. $aux->usu_apellido_materno;
        }
        $odontologos = $odontologos->pluck('usu_nombre_completo', 'usu_id');
        
        foreach ($plan_detalle as $detalle) {
            $detalle->tratamiento = Tratamientos::findOrFail($detalle->tra_id);
            $detalle->piezas_seleccionadas = PiezasDentales::findOrFail($detalle->pde_id);
        }

        //listado de Piezas dentales
        $pieza_dental = PiezasDentales::pluck('pde_codigo_pieza', 'pde_id');
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

        return view('planes-de-tratamientos.edit')->with('plan',$plan)->with('paciente', $paciente)->with('costos_tratamientos', $costos_tratamientos)->with('pieza_dental', $pieza_dental)->with('antecedentes', $antecedentes)->with('tipos_antecedentes', $tipos_antecedentes)->with('nombres_tratamientos', $nombres_tratamientos)->with('plan', $plan)->with('plan_detalle', $plan_detalle)->with('odontologos', $odontologos);

    }

    public function update($id, request $request){
        dd($request);
        $plan = PlanesDeTratamientos::findOrFail($id);
        if ($plan->ept_id != 1) {
            return redirect('planes-de-tratamientos')->with('destroyStatus', '¡Ya no se Puede Modificar Plan!');
        }
        $paciente = Pacientes::findOrFail($plan->pac_id);
        $plan->pdt_costo_total = $request->pdt_costo_total;
        $plan->pac_id = $pac_id;
        $plan->usu_id = Auth::user()->usu_id;
        $plan->ept_id = 1;
        $plan->save();
        $paciente->pac_observaciones = $request->pac_observaciones;
        $paciente->pac_motivo = $request->pac_motivo;
        $paciente->save();

        DB::table('plan_de_tratamiento_tratamiento')->where('pdt_id', $id)->delete();
        $c = count($request->tra_id);
        $i = 0;
        while($i < $c){
            $plan_de_tratamiento = new PlandeTratamientoTratamiento();
            $plan_de_tratamiento->pdt_id = $pdt_id;
            $plan_de_tratamiento->pde_id = $request->pde_id[$i];
            $plan_de_tratamiento->tra_id = $request->tra_id[$i];
            $plan_de_tratamiento->save();

            $i++;
        }

        return redirect('planes-de-tratamientos')->with('status', '¡Plan creado con exito!');
    }

    //destroy
  public function destroy($id){

    $plan = PlanesDeTratamientos::findOrFail($id);
    $pac_id = $plan->pac_id;
    //query para eliminar todos los elementos, en base al id entregado
    DB::table('plan_de_tratamiento_tratamiento')->where('pdt_id', $id)->delete();
    DB::table('sesiones_ejecucion_tratamiento')->where('pdt_id', $id)->delete();
    $plan->delete();

    return redirect()->route('planes-de-tratamientos.pacienteindex', ['id' => $pac_id])->with('destroyStatus', '¡Plan eliminado con exito!');
    
  }//end destory






    public function show($id)
    {
        $plan = PlanesDeTratamientos::findOrFail($id);
        
        
        //información del paciente
        $paciente = Pacientes::findOrFail($plan->pac_id);

        $paciente->pac_rut_completo = $paciente->pac_rut . '-' . $paciente->pac_dv;
        $paciente->pac_nombre_completo = $paciente->pac_nombres . ' ' . $paciente->pac_apellido_paterno . ' ' . $paciente->pac_apellido_materno;
        //listado de Tratamientos
        $nombres_tratamientos = Tratamientos::pluck('tra_nombre', 'tra_id');
        $costos_tratamientos = Tratamientos::pluck('tra_costo', 'tra_id');
        
        $plan_detalle = DB::table('plan_de_tratamiento_tratamiento')->where('pdt_id', $plan->pdt_id)->get();

        $odontologos = Usuarios::where('usu_rol', '!=', 2)->get();
        foreach ($odontologos as $aux) {
            $aux->usu_nombre_completo = $aux->usu_nombres . ' '. $aux->usu_apellido_paterno . ' '. $aux->usu_apellido_materno;
        }
        $odontologos = $odontologos->pluck('usu_nombre_completo', 'usu_id');
        
        foreach ($plan_detalle as $detalle) {
            $detalle->tratamiento = Tratamientos::findOrFail($detalle->tra_id);
            $detalle->piezas_seleccionadas = PiezasDentales::findOrFail($detalle->pde_id);
        }

        //listado de Piezas dentales
        $pieza_dental = PiezasDentales::pluck('pde_codigo_pieza', 'pde_id');
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

        return view('planes-de-tratamientos.show')->with('plan',$plan)->with('paciente', $paciente)->with('costos_tratamientos', $costos_tratamientos)->with('pieza_dental', $pieza_dental)->with('antecedentes', $antecedentes)->with('tipos_antecedentes', $tipos_antecedentes)->with('nombres_tratamientos', $nombres_tratamientos)->with('plan', $plan)->with('plan_detalle', $plan_detalle)->with('odontologos', $odontologos);

    }


}
