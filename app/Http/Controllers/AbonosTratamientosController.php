<?php

namespace App\Http\Controllers;

//use models
use App\AbonosTratamientos;
use App\PlanesDeTratamientos;
use App\Pacientes;
use App\Tratamientos;
use App\PiezasDentales;
use App\PlandeTratamientoTratamiento;
use App\EstadosPlanesDeTratamientos;

//use Laravel Tools
use Illuminate\Http\Request;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use auth;

class AbonosTratamientosController extends Controller
{
    
      public function __construct()
    {
      $this->middleware('auth');
    }

    public function index($pdt_id)
    {
        //dd('funciono');
        $abonos = AbonosTratamientos::where('pdt_id', $pdt_id)->orderBy('abt_fecha','DESC')->paginate(10);
        $plan = PlanesDeTratamientos::findorFail($pdt_id);
        $suma = 0;
        foreach ($abonos as $aux) {
            $aux->paciente = Pacientes::findOrFail($aux->pac_id);
            $suma = $suma + $aux->abt_monto_abonado;
        }
        if ($suma >= $plan->pdt_costo_total) {
           $mensaje = true;
        }else {
            $mensaje = false;
        }
        return view('abonos-tratamientos.index')->with('abonos', $abonos)->with('plan', $plan)->with('id',$pdt_id)->with('mensaje', $mensaje);

    }


    public function create($pdt_id)
    {
        

        $plan = PlanesDeTratamientos::findorFail($pdt_id);
        if ($plan->ept_id == 5 || $plan->ept_id == 4) {
            return redirect('planes-de-tratamientos')->with('destroyStatus', '¡Este Plan esta completado o cancelado!');
        }
        
        $abonos_anteriores = DB::table('abonos_tratamientos')->where('pdt_id', $plan->pdt_id)->get();
        $c = count($abonos_anteriores);
        if ($c == 0) {
            $abonos_anteriores = null;
        }
        $suma = 0;
        if ($abonos_anteriores) {
              foreach ($abonos_anteriores as $aux) {
                  $suma = $suma + $aux->abt_monto_abonado;
              }
              if ($suma >= $plan->pdt_costo_total) {
                return back()->with('Status', '¡El tratamiento esta totalmente cancelado, no es necesario otro abono!');
                }
          }  

        $paciente = Pacientes::findorFail($plan->pac_id);

        $paciente->pac_rut_completo = $paciente->pac_rut . '-' . $paciente->pac_dv;
        $paciente->pac_nombre_completo = $paciente->pac_nombres . ' ' . $paciente->pac_apellido_paterno . ' ' . $paciente->pac_apellido_materno;
        $plan_detalle = DB::table('plan_de_tratamiento_tratamiento')->where('pdt_id', $plan->pdt_id)->get();
        foreach ($plan_detalle as $detalle) {
            $detalle->tratamiento = Tratamientos::findOrFail($detalle->tra_id);
            $detalle->piezas_seleccionadas = PiezasDentales::findOrFail($detalle->pde_id);
        }
        
        return view('abonos-tratamientos.create')->with('plan', $plan)->with('paciente', $paciente)->with('plan_detalle', $plan_detalle)->with('abonos_anteriores', $abonos_anteriores);


    } 
    public function store(request $request, $pdt_id)
    {
        $plan = PlanesDeTratamientos::findorFail($pdt_id);
        if ($plan->ept_id == 5 || $plan->ept_id == 4) {
            return redirect('planes-de-tratamientos')->with('destroyStatus', '¡Este Plan esta completado o cancelado!');
        }
        $this->validate($request, [
            'abt_monto_abonado' => 'required|integer|min:1',
         ]);

        $abonos_anteriores = DB::table('abonos_tratamientos')->where('pdt_id', $plan->pdt_id)->get();
        $c = count($abonos_anteriores);
        if ($c == 0) {
            $abonos_anteriores = null;
        }
        $suma = 0;
        if ($abonos_anteriores) {
              foreach ($abonos_anteriores as $aux) {
                  $suma = $suma + $aux->abt_monto_abonado;
              }

          }  
    	$suma = $suma + $request->abt_monto_abonado;
        if ($suma > $plan->pdt_costo_total) {
               return back()->with('destroyStatus', '¡EL Monto ingresado es mayor al costo total!');
        }
        
        $abono = new AbonosTratamientos();
        $abono->abt_monto_abonado = $request->abt_monto_abonado;
        $abono->abt_fecha = date('Y-m-d');
        $abono->pdt_id = $pdt_id;
        $abono->pac_id = $plan->pac_id;
        $abono->save();
        return view('abonos-tratamientos.index')->with('id',$pdt_id)->with('status', 'Paciente Actualizado con exito!');
    }

    public function destroy($id)
    {

        $abono = AbonosTratamientos::findorFail($id);
        $abono->delete();
        return back()->with('destroyStatus', '¡Abono eliminado con exito!');
    }

}
