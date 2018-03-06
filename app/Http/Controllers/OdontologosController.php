<?php

namespace App\Http\Controllers;

//use models
use App\Odontologos;
use App\Especialidades;
use App\EspecialidadOdontologo;

use Illuminate\Http\Request;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\Facades\DB;
use Malahierba\ChileRut\ChileRut;


class OdontologosController extends Controller
{

    public function index(){

      $odontologos = Odontologos::orderBy('odo_id','ASC')->paginate(10); 
      return view('odontologos.index')->with('odontologos', $odontologos);
    }


    public function create(){
      	$odontologo = new Odontologos();
      	$especialidades = Especialidades::pluck('esp_nombre', 'esp_id');

      	return view('odontologos.create')->with('odontologo',$odontologo)->with('especialidades', $especialidades);
    }

    //guardar formulario en la BD
    public function store(request $request){

      $this->validate($request, [
      'odo_rut_completo' => 'required',
      'odo_nombres'=>'required|regex:[^[a-zA-Z_áéíóúÁÉÍÓÚñ\s]*$]|min:3|max:100',
      'odo_apellidos'=>'required|regex:[^[a-zA-Z_áéíóúÁÉÍÓÚñ\s]*$]|min:3|max:100',
      'odo_direccion'=>'required|regex:[^[\sa-zA-Z0-9áéíóúAÉÍÓÚÑñ.,#:;-]+$]|min:3|max:200',
      'odo_telefono'=>'required|integer|min:111111111|max:99999999999',
      'odo_email'=> '|required|email',
      'odo_fecha_nacimiento'=>'required|date',
      'odo_usuario'=>'required',
      'odo_password'=>'required',
      'odo_rol' => 'required',
      ]);

      $odontologo = new Odontologos($request->all());

      $apellidos = explode(' ',$request->odo_apellidos);
    

      if (count($apellidos) == 2) {
        $odontologo->odo_apellido_paterno = $apellidos[0];
        $odontologo->odo_apellido_materno = $apellidos[1];

      }elseif (count($apellidos)>2) {
        return redirect('odontologos/create')
                          ->withErrors('Ingrese solamente el apellido paterno y materno en el campo Apellidos')
                          ->withInput();

      }elseif (count($apellidos) == 1) {
        $odontologo->odo_apellido_paterno = $apellidos[0];
      }

      //validacion rut
      $rut_completo = $request->odo_rut_completo;
       $chilerut = new ChileRut;
      if ($chilerut->check($rut_completo)) {

        $rut = explode('-', $rut_completo);
        $num_rut = intval(preg_replace('/[^0-9]+/', '', $rut[0]), 10);
        $odontologo->odo_rut = $num_rut;
        $odontologo->odo_dv = $rut[1];


      }
        else{
           return redirect('odontologos/create')
                          ->withErrors('El RUT ingresado no es un rut valido')
                          ->withInput();

        }

        if ($odontologo->odo_password == $request->odo_confirmar_password) {
              //encriptar contraseña
        }else{
          return redirect('odontologos/create')
                          ->withErrors('Las Contraseñas no Coinciden')
                          ->withInput();

        }

          
        $odontologo->save();
        

        if ($request->esp_id != null){
            $odo_id =  DB::table('odontologos')->where('odo_rut', $odontologo->odo_rut)->value('odo_id');
            $all_especialidades = $request->esp_id;
            $b = count($all_especialidades);
            if($b > 1){
              $especialidades_filtradas = array_unique($all_especialidades);  
            }else{
              $especialidades_filtradas = $request->esp_id;
            }
            foreach ($especialidades_filtradas as $esp_id) {
                $especialidad = new EspecialidadOdontologo();
                $especialidad->esp_id = $esp_id;
                $especialidad->odo_id = $odo_id;
                $especialidad->save();
            }

        }
        
            

       return redirect('odontologos')->with('status', '¡Odontologo creado con exito!');


    }
    //end store

    

    public function edit($id){
        $odontologo = Odontologos::findOrFail($id);

        $odontologo->odo_rut_completo = $odontologo->odo_rut . "-". $odontologo->odo_dv;

        if ($odontologo->odo_apellido_materno != NULL) {
          $odontologo->odo_apellidos = $odontologo->odo_apellido_paterno . " " . $odontologo->odo_apellido_materno;

        }else{
          $odontologo->odo_apellidos = $odontologo->odo_apellido_paterno;
          
        }

        $especialidad_odontologo = DB::table('especialidad_odontologo')->where('odo_id', $odontologo->odo_id)->pluck('esp_id');
        $c = count($especialidad_odontologo);
          if ($c == 1) {
            $especialidades = Especialidades::findOrFail($especialidad_odontologo[0]);
          }
          elseif ($c > 1) {
            $i= 0;
            while($i != $c){
              $especialidades[$i] = Especialidades::findOrFail($especialidad_odontologo[$i]);
              $i++;
            }
          }
          else{
            $especialidades = new Especialidades();
         
          }
       
        $esp = Especialidades::pluck('esp_nombre', 'esp_id');

        return view('odontologos.edit')->with('odontologo',$odontologo)->with('especialidades', $especialidades)->with('esp', $esp);
    }

    public function update(request $request, $id){

        $this->validate($request, [
          'odo_rut_completo' => 'required',
          'odo_nombres'=>'required|regex:[^[a-zA-Z_áéíóúÁÉÍÓÚñ\s]*$]|min:3|max:100',
          'odo_apellidos'=>'required|regex:[^[a-zA-Z_áéíóúÁÉÍÓÚñ\s]*$]|min:3|max:100',
          'odo_direccion'=>'required|regex:[^[\sa-zA-Z0-9áéíóúAÉÍÓÚÑñ.,#:;-]+$]|min:3|max:200',
          'odo_telefono'=>'required|numeric|min:111111111|max:99999999999',
          'odo_email'=> '|required|email',
          'odo_fecha_nacimiento'=>'required|date',
          'odo_usuario'=>'required',
          'odo_rol'=>'required',
           ]);

        $odontologo = Odontologos::findOrFail($id);
        $odontologo->odo_nombres = $request->odo_nombres;
        $odontologo->odo_direccion = $request->odo_direccion;
        $odontologo->odo_telefono = $request->odo_telefono;
        $odontologo->odo_email = $request->odo_email;
        $odontologo->odo_fecha_nacimiento = $request->odo_fecha_nacimiento;
        $odontologo->odo_usuario= $odontologo->odo_usuario;
        

        $apellidos = explode(' ',$request->odo_apellidos);
      

      if (count($apellidos) == 2) {
        $odontologo->odo_apellido_paterno = $apellidos[0];
        $odontologo->odo_apellido_materno = $apellidos[1];

      }elseif (count($apellidos)>2) {
        return redirect('odontologos/edit', ['id' => $id])
                          ->withErrors('Ingrese solamente el apellido paterno y materno en el campo Apellidos')
                          ->withInput();

      }elseif (count($apellidos) == 1) {
        $odontologo->odo_apellido_paterno = $apellidos[0];
      }

       $rut_completo = $request->odo_rut_completo;
       $chilerut = new ChileRut;
      if ($chilerut->check($rut_completo)) {

        $rut = explode('-', $rut_completo);
        $num_rut = intval(preg_replace('/[^0-9]+/', '', $rut[0]), 10);
        $odontologo->odo_rut = $num_rut;
        $odontologo->odo_dv = $rut[1];


      }
        else{
           return redirect('odontologos/edit', ['id'=> $id])
                          ->withErrors('El RUT ingresado no es un rut valido')
                          ->withInput();

        }

        $odontologo->save();
        $esp_id_anteriores = DB::table('especialidad_odontologo')->where('odo_id', $id)->pluck('esp_id');
        //si existen especialidades anteriores
        
        if($esp_id_anteriores != null && $request->esp_id != NULL){
          //si esp_id_anteriores esta en el request, sacarlo de esta, y si no esta, eliminar de la bd
          $c = count($esp_id_anteriores);
          $j = 0;
          while ($j < $c) {
            $array_especialidades[$j] = $esp_id_anteriores[$j];
            $j++; 

          }
          $esp_filtradas = array_unique($request->esp_id);
          foreach ($esp_filtradas as $new_especialidad) {
            if (in_array($new_especialidad, $array_especialidades)) {
                
            }else{                
                  $especialidad = new EspecialidadOdontologo();
                  $especialidad->esp_id = $new_especialidad;
                  $especialidad->odo_id = $id;
                  $especialidad->save();
                }
          }
          
          $esp_borradas = array_diff($array_especialidades, $request->esp_id);
         
          //por cada especualidad borrada borrar un especialidad_odontologo
          foreach ($esp_borradas as $borrar ) {
            DB::table('especialidad_odontologo')->where('esp_id', $borrar)->delete();
          }
  

        }
        //si no existen especialidades anteriores
        elseif($esp_id_anteriores == NULL && $request->esp_id != NULL){
            $all_especialidades = $request->esp_id;
            $b = count($all_especialidades);
            if($b > 1){
              $especialidades_filtradas = array_unique($all_especialidades);  
            }else{
              $especialidades_filtradas = $request->esp_id;
            }
            foreach ($especialidades_filtradas as $esp_id) {
              $especialidad = new EspecialidadOdontologo();
              $especialidad->esp_id = $esp_id;
              $especialidad->odo_id = $id;
              $especialidad->save();
            }
          
            
        }elseif($esp_id_anteriores != NULL && $request->esp_id == NULL){
            DB::table('especialidad_odontologo')->where('odo_id', $id)->delete();
        }
        
        dd('se te olvido un dd tawe');

        return redirect('odontologos')->with('status', '¡Odontologo actualizado con exito!');


    }

    
    public function destroy($id){

      $odontologo = Odontologos::findOrFail($id);
      $especialidades = DB::table('especialidad_odontologo')->where('odo_id', $id)->get();
      if ($especialidades) {
        DB::table('especialidad_odontologo')->where('odo_id', $id)->delete();
      }

      $odontologo->delete();

    return redirect()->route('odontologos.index')->with('destroyStatus', 'Odontologo eliminado con exito!');
    
    }//end destory



    public function show($id){

      $odontologo = Odontologos::findOrFail($id);
      $especialidad_odontologo = DB::table('especialidad_odontologo')->where('odo_id', $odontologo->odo_id)->pluck('esp_id');
        $c = count($especialidad_odontologo);
          if ($c == 1) {
            $especialidades = Especialidades::findOrFail($especialidad_odontologo[0]);
          }
          elseif ($c > 1) {
            $i= 0;
            while($i != $c){
              $especialidades[$i] = Especialidades::findOrFail($especialidad_odontologo[$i]);
              $i++;
            }
          }
          else{
            $especialidades = NULL;
         
          }
       

      return view('odontologos.show')->with('odontologo',$odontologo)->with('especialidades', $especialidades);

      
    }


}
