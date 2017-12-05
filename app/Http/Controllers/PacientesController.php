<?php

namespace App\Http\Controllers;
//use models
use App\Pacientes;
use App\AntecedentesMedicosGenerales;
use App\TiposAntecedentes;
//use laravel tools
use Malahierba\ChileRut\ChileRut;
use Illuminate\Http\Request;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

class PacientesController extends Controller
{


public function index(){

  $pacientes = Pacientes::orderBy('pac_id','ASC')->paginate(10); 
  return view('pacientes.index')->with('pacientes',$pacientes);
}




//actionCreate
  public function create(){
    
    $antecedentes = new AntecedentesMedicosGenerales();
    $tipos = TiposAntecedentes::pluck('tan_tipo', 'tan_id');
 
    return view('pacientes.create', compact('tipos', $tipos))->with('antecedentes',$antecedentes);

  }
//actionView
  
  public function show($id){

    $paciente = Pacientes::findOrFail($id);

    $amg_id =  DB::table('antecedentes_medicos_generales')->where('pac_id', $id)->value('amg_id');

    
    if ($amg_id != NULL) {
      $antecedentes = AntecedentesMedicosGenerales::findOrFail($amg_id);
      
    }else{
      $antecedentes = new AntecedentesMedicosGenerales(); 
    }
    
    
    return view('pacientes.show', compact('paciente','antecedentes'));



  }
  //end view

  //save()
  public function store(Request $request){

    
     $this->validate($request, [
        'pac_rut_completo' => 'required',
        'pac_edad'=>'min:1|max:117|numeric',
        'pac_nombres'=>'required|regex:[^[a-zA-Z_áéíóúÁÉÍÓÚñ\s]*$]|min:3|max:100',
        'pac_apellidos'=>'required|regex:[^[a-zA-Z_áéíóúÁÉÍÓÚñ\s]*$]|min:3|max:100',
        'pac_direccion'=>'required|regex:[^[\sa-zA-Z0-9áéíóúAÉÍÓÚÑñ.,#:;-]+$]|min:3|max:200',
        'pac_telefono'=>'required|numeric|min:111111111|max:99999999999',
        'pac_observaciones'=>'required|regex:[^[\sa-zA-Z0-9áéíóúAÉÍÓÚÑñ.,:;-]+$]|min:3|max:200',
        'pac_motivo'=>'required|regex:[^[\sa-zA-Z0-9áéíóúAÉÍÓÚÑñ.,:;-]+$]|min:3|max:200',
        'amg_descripcion'=> 'min:3|max:200|regex:[^[\sa-zA-Z0-9áéíóúAÉÍÓÚÑñ.,:;-]+$]', 
    ]);

    	
  	$paciente = new Pacientes($request->all());
    $antecedentes = new AntecedentesMedicosGenerales($request->all());
    
    $rut_completo = $request->pac_rut_completo;
    
    
    
    $apellidos = explode(' ',$request->pac_apellidos);
    

    if (count($apellidos) == 2) {
      $paciente->pac_apellido_paterno = $apellidos[0];
      $paciente->pac_apellido_materno = $apellidos[1];

    }elseif (count($apellidos)>2) {
      return redirect('pacientes/create')
                        ->withErrors('Ingrese solamente el apellido paterno y materno en el campo Apellidos')
                        ->withInput();

    }elseif (count($apellidos) == 1) {
      $paciente->pac_apellido_paterno = $apellidos[0];
    }
    


    $chilerut = new ChileRut;
    if ($chilerut->check($rut_completo)) {

      $rut = explode('-', $rut_completo);
      $num_rut = intval(preg_replace('/[^0-9]+/', '', $rut[0]), 10);
      $paciente->pac_rut = $num_rut;
      $paciente->pac_dv = $rut[1];


    }
      else{
         return redirect('pacientes/create')
                        ->withErrors('El RUT ingresado no es un rut valido')
                        ->withInput();

      }

  
  
  $paciente->save();
  
  $pac_id =  DB::table('pacientes')->where('pac_rut', $paciente->pac_rut)->value('pac_id');
 
  if($antecedentes->amg_descripcion !=null){

    $antecedentes->pac_id = $pac_id;
  	$antecedentes->save();


  }
  return redirect('pacientes')->with('status', 'Paciente creado con exito!');


  }
  //end store

  //edit
  public function edit($id){
    
    
    $pacientes = Pacientes::findOrFail($id);
    $pacientes->pac_rut_completo = $pacientes->pac_rut . "-". $pacientes->pac_dv;

    if ($pacientes->pac_apellido_materno != NULL) {
      $pacientes->pac_apellidos = $pacientes->pac_apellido_paterno . " " . $pacientes->pac_apellido_materno;

    }else{
      $pacientes->pac_apellidos = $pacientes->pac_apellido_paterno;
      
    }
    

    $tipos = TiposAntecedentes::pluck('tan_tipo', 'tan_id');
    $amg_id = DB::table('antecedentes_medicos_generales')->where('pac_id', $id)->value('amg_id');
    if ($amg_id != null) {
       $antecedentes = AntecedentesMedicosGenerales::find($amg_id);
    }else{
      $antecedentes = new AntecedentesMedicosGenerales();
    }
    
    return view('pacientes.edit', compact('tipos', $tipos))->with('pacientes', $pacientes)->with('antecedentes', $antecedentes);
    
  }

  public function update(request $request, $id){

    $this->validate($request, [
        'pac_rut_completo' => 'required',
        'pac_edad'=>'min:1|max:117|numeric',
        'pac_nombres'=>'required|regex:[^[a-zA-Z_áéíóúÁÉÍÓÚñ\s]*$]|min:3|max:100',
        'pac_apellidos'=>'required|regex:[^[a-zA-Z_áéíóúÁÉÍÓÚñ\s]*$]|min:3|max:100',
        'pac_direccion'=>'required|regex:[^[\sa-zA-Z0-9áéíóúAÉÍÓÚÑñ.,#:;-]+$]|min:3|max:200',
        'pac_telefono'=>'required|numeric|min:111111111|max:99999999999',
        'pac_observaciones'=>'required|regex:[^[\sa-zA-Z0-9áéíóúAÉÍÓÚÑñ.,:;-]+$]|min:3|max:200',
        'pac_motivo'=>'required|regex:[^[\sa-zA-Z0-9áéíóúAÉÍÓÚÑñ.,:;-]+$]|min:3|max:200',
        'amg_descripcion'=> 'min:3|max:200|regex:[^[\sa-zA-Z0-9áéíóúAÉÍÓÚÑñ.,:;-]+$]', 
    ]);

    $paciente = Pacientes::findOrFail($id);
    $paciente->pac_nombres = $request->pac_nombres;
    $paciente->pac_edad = $request->pac_edad;
    $paciente->pac_direccion = $request->pac_direccion;
    $paciente->pac_telefono = $request->pac_telefono;
    $paciente->pac_motivo = $request->pac_motivo;
    $paciente->pac_observaciones = $request->pac_observaciones;


    //validacion apellidos
    $apellidos = explode(' ',$request->pac_apellidos);
    if (count($apellidos) == 2) {
      $paciente->pac_apellido_paterno = $apellidos[0];
      $paciente->pac_apellido_materno = $apellidos[1];

    }elseif (count($apellidos)>2) {
      return redirect('pacientes/create')
                        ->withErrors('Ingrese solamente el apellido paterno y materno en el campo Apellidos')
                        ->withInput();

    }elseif (count($apellidos) == 1) {
      $paciente->pac_apellido_paterno = $apellidos[0];
    }

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
    
    $paciente->save();

    $amg_id =  DB::table('antecedentes_medicos_generales')->where('pac_id', $id)->value('amg_id');
    
    
    if($request->amg_descripcion !=null && $amg_id != NULL){
    
    $antecedentes = AntecedentesMedicosGenerales::findOrFail($amg_id);

    $antecedentes->pac_id = $id;
    $antecedentes->tan_id = $request->tan_id;
    $antecedentes->amg_descripcion = $request->amg_descripcion;
    $antecedentes->save();


  }elseif ($request->amg_descripcion != NULL && $amg_id == NULL) {

    $antecedentes = new AntecedentesMedicosGenerales($request->all());

    $antecedentes->pac_id = $id;
    $antecedentes->tan_id = $request->tan_id;
    $antecedentes->amg_descripcion = $request->amg_descripcion;
    $antecedentes->save();
  }

  return redirect('pacientes')->with('status', 'Paciente Actualizado con exito!');

  }


//destroy
  public function destroy($id){

    $paciente = Pacientes::findOrFail($id);
    $paciente->delete();

    return redirect()->route('pacientes.index')->with('destroyStatus', 'Paciente eliminado con exito!');
    
  }//end destory



}
