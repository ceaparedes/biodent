<?php

namespace App\Http\Controllers;
//use project Models
use App\Pacientes;
use App\AntecedentesMedicosGenerales;
use App\TiposAntecedentes;
use App\Comuna;
//use laravel tools & helpers
use Malahierba\ChileRut\ChileRut;
use Illuminate\Http\Request;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

class PacientesController extends Controller
{

  public function __construct()
  {
      $this->middleware('auth');
  }

//funcion index
public function index(){

  $pacientes = Pacientes::orderBy('pac_id','ASC')->paginate(10); 
  return view('pacientes.index')->with('pacientes',$pacientes);
}


//function create
public function create(){
    
    $antecedentes = new AntecedentesMedicosGenerales();
    $tipos = TiposAntecedentes::pluck('tan_tipo', 'tan_id');
    $comuna = Comuna::pluck('com_nombre', 'com_id');
 
    return view('pacientes.create', compact('tipos', $tipos))->with('antecedentes',$antecedentes)->with('comuna', $comuna);

  }


//function store
  public function store(Request $request){
      //validaciones  
      $this->validate($request, [
        'pac_rut_completo' => 'required',
        'pac_edad'=>'required|min:1|max:117|integer',
        'pac_fecha_nacimiento'=>'required',
        'pac_nombres'=>'required|regex:[^[a-zA-Z_áéíóúÁÉÍÓÚñ\s]*$]|min:3|max:100',
        'pac_apellido_paterno'=>'required|regex:[^[a-zA-Z_áéíóúÁÉÍÓÚñ\s]*$]|min:3|max:50',
        'pac_apellido_materno'=>'required|regex:[^[a-zA-Z_áéíóúÁÉÍÓÚñ\s]*$]|min:3|max:50',
        'pac_direccion'=>'required|regex:[^[\sa-zA-Z0-9áéíóúAÉÍÓÚÑñ.,#:;-]+$]|min:3|max:200',
        'pac_telefono'=>'required|integer|min:111111111|max:99999999999',
        'pac_observaciones'=>'required|regex:[^[\sa-zA-Z0-9áéíóúAÉÍÓÚÑñ.,:;-]+$]|min:3|max:200',
        'pac_motivo'=>'required|regex:[^[\sa-zA-Z0-9áéíóúAÉÍÓÚÑñ.,:;-]+$]|min:3|max:200',
        'com_id'=>'required',
        'pac_email' => 'required|email',
        'pac_fecha_nacimiento'=>'date',
      ]);
      
   
     $paciente = new Pacientes($request->all());
    
    //validacion rut ingresado
     $rut_completo = $request->pac_rut_completo;  
     $chilerut = new ChileRut;
    if ($chilerut->check($rut_completo)) {
      //si el rut es correcto, se eliminan puntos y guion y se almacenan en inputs (pac_rut y pac_dv)
      $rut = explode('-', $rut_completo);
      $num_rut = intval(preg_replace('/[^0-9]+/', '', $rut[0]), 10);
      $paciente->pac_rut = $num_rut;
      $paciente->pac_dv = $rut[1];
    }
      else{
        //si el rut no es valido se devuelve el mensaje de error
         return redirect('pacientes/create')
                        ->withErrors('El RUT ingresado no es un rut valido')
                        ->withInput();
      }
  
    //almacenar paciente y comuna en la BD
    $paciente->save();

    //si el paciente tiene un antecedente
    if($request->tan_id != NULL){
         //se invoca a la id para hacer la asociacion entre paciente y antecedente medico general
         $pac_id =  DB::table('pacientes')->where('pac_rut', $paciente->pac_rut)->value('pac_id');
         $c = count($request->tan_id);
         $i = 0;
         //por cada elemento, se almacena en la bd.
         while ($i < $c) {
            $antecedentes = new AntecedentesMedicosGenerales();
            $antecedentes->tan_id = $request->tan_id[$i];
            $antecedentes->amg_descripcion = $request->amg_descripcion[$i];
            $antecedentes->pac_id = $pac_id;
            $antecedentes->save();
            $i++;
         }//endwhile
    }//endIF

   //se retorna al index y con el respectivo mensaje de exito
    return redirect('pacientes')->with('status', '¡Paciente creado con exito!');


  }
  //end store

  //editar
  public function edit($id){
    
    //se llama al paciente en base a la id, en caso que no encuentre a alguien arroja error 404
    $paciente = Pacientes::findOrFail($id);
    //para efectos visuales, se concatenan el rut con su respectivo dv
    $paciente->pac_rut_completo = $paciente->pac_rut . "-". $paciente->pac_dv;

    $comuna = Comuna::pluck('com_nombre','com_id');
    //trae los tipos para hacer el dropdown
    $tipos = TiposAntecedentes::pluck('tan_tipo', 'tan_id');
    //trae todas las ID que tengan asociacion con el paciente
    $amg_id = DB::table('antecedentes_medicos_generales')->where('pac_id', $id)->pluck('amg_id');
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
      //en caso de que no existan antecedentes se crea un nuevo antecedente 
      $antecedentes = new AntecedentesMedicosGenerales();
   
    }
   
    return view('pacientes.edit', compact('tipos', $tipos))->with('paciente', $paciente)->with('antecedentes', $antecedentes)->with('comuna', $comuna);
    
  }

  public function update(request $request, $id){
     //validaciones  
    $this->validate($request, [
      'pac_rut_completo' => 'required',
      'pac_edad'=>'required|min:1|max:117|integer',
      'pac_fecha_nacimiento'=>'required',
      'pac_nombres'=>'required|regex:[^[a-zA-Z_áéíóúÁÉÍÓÚñ\s]*$]|min:3|max:100',
      'pac_apellido_paterno'=>'required|regex:[^[a-zA-Z_áéíóúÁÉÍÓÚñ\s]*$]|min:3|max:50',
      'pac_apellido_materno'=>'required|regex:[^[a-zA-Z_áéíóúÁÉÍÓÚñ\s]*$]|min:3|max:50',
      'pac_direccion'=>'required|regex:[^[\sa-zA-Z0-9áéíóúAÉÍÓÚÑñ.,#:;-]+$]|min:3|max:200',
      'pac_telefono'=>'required|integer|min:111111111|max:99999999999',
      'pac_observaciones'=>'required|regex:[^[\sa-zA-Z0-9áéíóúAÉÍÓÚÑñ.,:;-]+$]|min:3|max:200',
      'pac_motivo'=>'required|regex:[^[\sa-zA-Z0-9áéíóúAÉÍÓÚÑñ.,:;-]+$]|min:3|max:200',
      'com_id'=>'required',
      'pac_email' => 'required|email',
      'pac_fecha_nacimiento'=>'date',
    ]);
    //se actualizan los datos input por input
    $paciente = Pacientes::findOrFail($id);
    $paciente->pac_nombres = $request->pac_nombres;
    $paciente->pac_apellido_paterno = $request->pac_apellido_paterno;
    $paciente->pac_edad = $request->pac_edad;
    $paciente->pac_direccion = $request->pac_direccion;
    $paciente->pac_telefono = $request->pac_telefono;
    $paciente->pac_motivo = $request->pac_motivo;
    $paciente->pac_observaciones = $request->pac_observaciones;
    $paciente->com_id = $request->com_id;
    $paciente->pac_email = $request->pac_email;
    $paciente->pac_fecha_nacimiento = $request->pac_fecha_nacimiento;


    

    //validacion Rut
    $chilerut = new ChileRut;
    if ($chilerut->check($request->pac_rut_completo)) {

      $rut = explode('-', $request->pac_rut_completo);
      $num_rut = intval(preg_replace('/[^0-9]+/', '', $rut[0]), 10);
      $paciente->pac_rut = $num_rut;
      $paciente->pac_dv = $rut[1];


    }
      else{
         return redirect()->route('pacientes.edit', ['id' => $id])
                        ->withErrors('El RUT ingresado no es un rut valido')
                        ->withInput();
    }
    //guardar informacion del paciente 
    $paciente->save();
    //almacenar en objetos las ID, TIPO y Descripcion de los antecedentes.
    $amg_id_anteriores =  DB::table('antecedentes_medicos_generales')->where('pac_id', $id)->pluck('amg_id');
    $count_amg_anteriores = count($amg_id_anteriores);
    $count_new_amg = count($request->tan_id);
    
    //si ambos son 0 no se hace nada
    if ($count_amg_anteriores == 0 && $count_new_amg == 0) {
       return redirect('pacientes')->with('status', 'Paciente Actualizado con exito!');
    }//si existen nuevos amg, se insertan como si nada
    elseif ($count_amg_anteriores == 0 && $count_new_amg >0) {
        $i= 0;
        while($i < $count_new_amg){
          $antecedentes = new AntecedentesMedicosGenerales();
          $antecedentes->pac_id = $id;
          $antecedentes->tan_id = $request->tan_id[$i];
          $antecedentes->amg_descripcion = $request->amg_descripcion[$i];
          $antecedentes->save();
          $i++;
        }

    }//si no existen nuevos amg, pero existen anteriores, estos se eliminan
    elseif ($count_amg_anteriores > 0 && $count_new_amg == 0) {
        DB::table('antecedentes_medicos_generales')->where('pac_id', $id)->delete();
    }
    elseif ($count_amg_anteriores > $count_new_amg) {
        $i = 0;
        $suma = $count_amg_anteriores + $count_new_amg - 1;
        while($i < $count_new_amg){
          $antecedentes = AntecedentesMedicosGenerales::findOrFail($amg_id_anteriores[$i]);
          $antecedentes->tan_id = $request->tan_id[$i];
          $antecedentes->amg_descripcion = $request->amg_descripcion[$i];
          $antecedentes->save();
          $i++;
        }
        while ($i < $suma) {
          $antecedentes = AntecedentesMedicosGenerales::findOrFail($amg_id_anteriores[$i]);
          $antecedentes->delete();
          $i++;
        }

    }
    elseif ($count_amg_anteriores < $count_new_amg) {
        $i = 0;
        $suma = $count_amg_anteriores + $count_new_amg -1 ;
        while($i < $count_amg_anteriores){
          $antecedentes = AntecedentesMedicosGenerales::findOrFail($amg_id_anteriores[$i]);
          $antecedentes->tan_id = $request->tan_id[$i];
          $antecedentes->amg_descripcion = $request->amg_descripcion[$i];
          $antecedentes->save();
          $i++;
        }
        while ($i < $suma) {
          $antecedentes = new AntecedentesMedicosGenerales();
          $antecedentes->pac_id = $id;
          $antecedentes->tan_id = $request->tan_id[$i];
          $antecedentes->amg_descripcion = $request->amg_descripcion[$i];
          $antecedentes->save();
          $i++;
        }

    }
    elseif ($count_amg_anteriores == $count_new_amg && $count_amg_anteriores >0) {
        $i = 0;
        while($i < $count_amg_anteriores){
          $antecedentes = AntecedentesMedicosGenerales::findOrFail($amg_id_anteriores[$i]);
          $antecedentes->tan_id = $request->tan_id[$i];
          $antecedentes->amg_descripcion = $request->amg_descripcion[$i];
          $antecedentes->save();
          $i++;
        }

    }     

    return redirect('pacientes')->with('status', 'Paciente Actualizado con exito!');

  }//endUpdate


//destroy
  public function destroy($id){

    $paciente = Pacientes::findOrFail($id);
    //query para eliminar todos los elementos, en base al id entregado
    DB::table('antecedentes_medicos_generales')->where('pac_id', $id)->delete();
    $paciente->delete();

    return redirect()->route('pacientes.index')->with('destroyStatus', 'Paciente eliminado con exito!');
    
  }//end destory


  
  //funcion show
  public function show($id){

    $paciente = Pacientes::findOrFail($id);
    $paciente->pac_rut_completo = $paciente->pac_rut . '-' . $paciente->pac_dv;

    $comuna = Comuna::findOrFail($paciente->com_id);

    $tipos = TiposAntecedentes::pluck('tan_tipo', 'tan_id');
    //trae todas las ID que tengan asociacion con el paciente
    $amg_id = DB::table('antecedentes_medicos_generales')->where('pac_id', $id)->pluck('amg_id');
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
      //en caso de que no existan antecedentes se crea un nuevo antecedente 
      $antecedentes = null;
   
    }
    
    return view('pacientes.show')->with('paciente', $paciente)->with('comuna', $comuna)->with('antecedentes', $antecedentes)->with('tipos', $tipos);

  }
  //end view



}
