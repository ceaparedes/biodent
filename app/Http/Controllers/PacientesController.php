<?php

namespace App\Http\Controllers;
//use project Models
use App\Pacientes;
use App\AntecedentesMedicosGenerales;
use App\TiposAntecedentes;
//use laravel tools & helpers
use Malahierba\ChileRut\ChileRut;
use Illuminate\Http\Request;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

class PacientesController extends Controller
{

//funcion index
public function index(){

  $pacientes = Pacientes::orderBy('pac_id','ASC')->paginate(10); 
  return view('pacientes.index')->with('pacientes',$pacientes);
}




//function create
public function create(){
    
    $antecedentes = new AntecedentesMedicosGenerales();
    $tipos = TiposAntecedentes::pluck('tan_tipo', 'tan_id');
 
    return view('pacientes.create', compact('tipos', $tipos))->with('antecedentes',$antecedentes);

  }


//function store
  public function store(Request $request){

      //validaciones  
      $this->validate($request, [
        'pac_rut_completo' => 'required',
        'pac_edad'=>'min:1|max:117|integer',
        'pac_nombres'=>'required|regex:[^[a-zA-Z_áéíóúÁÉÍÓÚñ\s]*$]|min:3|max:100',
        'pac_apellido_paterno'=>'required|regex:[^[a-zA-Z_áéíóúÁÉÍÓÚñ\s]*$]|min:3|max:50',
        'pac_apellido_materno'=>'required|regex:[^[a-zA-Z_áéíóúÁÉÍÓÚñ\s]*$]|min:3|max:50',
        'pac_direccion'=>'required|regex:[^[\sa-zA-Z0-9áéíóúAÉÍÓÚÑñ.,#:;-]+$]|min:3|max:200',
        'pac_telefono'=>'required|integer|min:111111111|max:99999999999',
        'pac_observaciones'=>'required|regex:[^[\sa-zA-Z0-9áéíóúAÉÍÓÚÑñ.,:;-]+$]|min:3|max:200',
        'pac_motivo'=>'required|regex:[^[\sa-zA-Z0-9áéíóúAÉÍÓÚÑñ.,:;-]+$]|min:3|max:200',
        
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

  
    //almacenar paciente en la BD
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
   
    return view('pacientes.edit', compact('tipos', $tipos))->with('paciente', $paciente)->with('antecedentes', $antecedentes);
    
  }

  public function update(request $request, $id){
    //validaciones
    $this->validate($request, [
        'pac_rut_completo' => 'required',
        'pac_edad'=>'min:1|max:117|numeric',
        'pac_nombres'=>'required|regex:[^[a-zA-Z_áéíóúÁÉÍÓÚñ\s]*$]|min:3|max:100',
        'pac_apellido_paterno'=>'required|regex:[^[a-zA-Z_áéíóúÁÉÍÓÚñ\s]*$]|min:3|max:100',
        'pac_apellido_materno'=>'required|regex:[^[a-zA-Z_áéíóúÁÉÍÓÚñ\s]*$]|min:3|max:100',
        'pac_direccion'=>'required|regex:[^[\sa-zA-Z0-9áéíóúAÉÍÓÚÑñ.,#:;-]+$]|min:3|max:200',
        'pac_telefono'=>'required|numeric|min:111111111|max:99999999999',
        'pac_observaciones'=>'required|regex:[^[\sa-zA-Z0-9áéíóúAÉÍÓÚÑñ.,:;-]+$]|min:3|max:200',
        'pac_motivo'=>'required|regex:[^[\sa-zA-Z0-9áéíóúAÉÍÓÚÑñ.,:;-]+$]|min:3|max:200',
         
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


    

    //validacion Rut
    $chilerut = new ChileRut;
    if ($chilerut->check($request->pac_rut_completo)) {

      $rut = explode('-', $request->pac_rut_completo);
      $num_rut = intval(preg_replace('/[^0-9]+/', '', $rut[0]), 10);
      $paciente->pac_rut = $num_rut;
      $paciente->pac_dv = $rut[1];


    }
      else{
         return redirect('pacientes/create')
                        ->withErrors('El RUT ingresado no es un rut valido')
                        ->withInput();
    }
    //guardar informacion del paciente 
    $paciente->save();
    //almacenar en objetos las ID, TIPO y Descripcion de los antecedentes.
    $amg_id_anteriores =  DB::table('antecedentes_medicos_generales')->where('pac_id', $id)->pluck('amg_id');
    $tan_id_anteriores =  DB::table('antecedentes_medicos_generales')->where('pac_id', $id)->pluck('tan_id');
    $descripcion_anterior = DB::table('antecedentes_medicos_generales')->where('pac_id', $id)->pluck('amg_descripcion');
    if($amg_id_anteriores != null && $request->tan_id != NULL){ //si existen antecedentes anteriores y nuevos
      $c = count($amg_id_anteriores);
      $j = 0;
      while ($j < $c) { //transformar los objetos en array, en base a la cantidad de amg_id
        $array_amg_id_anteriores[$j] = $amg_id_anteriores[$j];
        $array_descripcion[$j] = $descripcion_anterior[$j];
        $array_tipos[$j] = $tan_id_anteriores[$j];
        $j++; 
      }
      $cont = count($request->tan_id); // se cuentan los request, y en base a ellos se hace el ciclo while
      $i = 0;
      while($i < $cont) {
        //se verifica que el elemento i este en el array que contiene los tipos de antecedentes.
        if (in_array($request->tan_id[$i], $array_tipos)){
          
          if($request->tan_id[$i] == $array_tipos[$i] && $request->amg_descripcion[$i] != $array_descripcion[$i] ) {
              //si se cambia SOLO la descripcion de un antcedente
              $antecedente = AntecedentesMedicosGenerales::findOrFail($amg_id_anteriores[$i]);
              $antecedente->amg_descripcion = $request->amg_descripcion[$i];
              $antecedente->save();
              $i++;
          }elseif ($request->tan_id[$i] != $array_tipos[$i] && $request->amg_descripcion[$i] == $array_descripcion[$i] ) {
              //si se modifica el tipo, manteniendo la descripcion
              $antecedente = AntecedentesMedicosGenerales::findOrFail($amg_id_anteriores[$i]);
              $antecedente->tan_id = $request->tan_id[$i];
              $antecedente->save();
              $i++;
          }elseif ($request->tan_id[$i] == $array_tipos[$i] && $request->amg_descripcion[$i] == $array_descripcion[$i]) {
             //si ambos elementos son iguales
              $i++;
          }
            
        }else{ 
            //si el tipo es nuevo, se hace una nueva insercion.
            $antecedente = new AntecedentesMedicosGenerales();
            $antecedente->tan_id = $request->tan_id[$i];
            $antecedente->pac_id = $id;
            $antecedente->amg_descripcion = $request->amg_descripcion[$i];
            //$antecedente->save();
            $i++;
        }
      }//endwhile
        //se traen todos los antecedentes (en un objeto)
        $antecedentes_nuevos =  DB::table('antecedentes_medicos_generales')->where('pac_id', $id)->pluck('amg_id');
        $c = count($antecedentes_nuevos);
        $a = 0;
        //while para transformar el objeto en array
        while ($a < $c) {
          $array_antecedentes_nuevos[$a] =$antecedentes_nuevos[$a];
          $a++; 
        }
        //se almacenan los elementos que ya no estan
        $esp_borradas = array_diff($array_amg_id_anteriores, $array_antecedentes_nuevos);
        
        //por cada antecedente borrado se borra dicho antecedente de la BD
        foreach ($esp_borradas as $borrar ) {
          
          DB::table('antecedentes_medicos_generales')->where('amg_id', $borrar)->delete();
        }

      }elseif($amg_id_anteriores == null && $request->tan_id != NULL){ 
        //si no hay ningun antecedente anterior, se insertan normalmente
          $cont = count($request->tan_id);
          $i = 0;
          while ($i < $cont) {
            $antecedente = new AntecedentesMedicosGenerales();
            $antecedente->tan_id = $request->tan_id[$i];
            $antecedente->pac_id = $id;
            $antecedente->amg_descripcion = $request->amg_descripcion[$i];
            $antecdente->save();
            $i++;
          }

      }elseif ($amg_id_anteriores != null && $request->tan_id == NULL) {
        // en el caso de que no haya ningun antecedente en el request, se elmiminan todos los antecedentes
        $antecedentes_nuevos =  DB::table('antecedentes_medicos_generales')->where('pac_id', $id)->pluck('amg_id');
        $c = count($antecedentes_nuevos);
        $a = 0;
        while ($a < $c) {
          $array_antecedentes_nuevos[$a] =$antecedentes_nuevos[$a];
          $a++; 
        }
        $esp_borradas = array_diff($array_amg_id_anteriores, $array_antecedentes_nuevos);
       
        //por cada antecedente borrado borrar dicho antecedente de la BD
        foreach ($esp_borradas as $borrar ) {
          DB::table('antecedentes_medicos_generales')->where('amg_id', $borrar)->delete();
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

    $amg_id =  DB::table('antecedentes_medicos_generales')->where('pac_id', $id)->pluck('amg_id');
    if($amg_id != null){
      $c =count($amg_id); // se cuentan las ids de los antecedentes
      if ($c == 1) {//si es 1 hace el proceso una ves
        $antecedentes = AntecedentesMedicosGenerales::findOrFail($amg_id);
        break;
      }
      //si es mas que uno, busca todos los antecedentes a traves del ciclo while
      $i = 0;
      while ($i < $c) {
        $antecedentes[$i] = AntecedentesMedicosGenerales::findOrFail($amg_id[$i]);
        $i++;
      }
      
    }else{//si es nulo llena antecedentes con NULL
      $antecedentes = NULL;
    }
   

    return view('pacientes.show')->with(['paciente' => $paciente, 'antecedentes' => $antecedentes]);

  }
  //end view



}
