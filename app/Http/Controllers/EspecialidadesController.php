<?php

namespace App\Http\Controllers;
//use models
use App\Especialidades;
//use laravel Tools
use Illuminate\Http\Request;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

class EspecialidadesController extends Controller
{
    
	public function index(){
    	
    	$especialidades = Especialidades::orderBy('esp_id','ASC')->paginate(10);
    	

    	return view('especialidades.index')->with('especialidades', $especialidades);	
    }

	//action Create
    public function create(){

    	$especialidad = new Especialidades();
    	
    	return view('especialidades.create')->with('especialidad', $especialidad);

    }

    //guardar nueva especialidades
    public function store(request $request){
    	
    	$this->validate($request,[
    		'esp_nombre'=>'required|regex:[^[a-zA-Z_áéíóúÁÉÍÓÚñ\s]*$]|min:3|max:100'
    	]);

    	$especialidad = new Especialidades($request->all());
    	$especialidad->save();


    	return redirect('especialidades')->with('status', '¡Especialidad Creada con Exito!');


    }

    public function edit($id){
    	$especialidad = Especialidades::findorFail($id);
    	return view('especialidades.edit')->with('especialidad', $especialidad);

    }

    public function update(request $request, $id){

    	$this->validate($request,[
    		'esp_nombre'=>'required|regex:[^[a-zA-Z_áéíóúÁÉÍÓÚñ\s]*$]|min:3|max:100'
    	]);

    	$especialidad = Especialidades::findorFail($id);
    	$especialidad->esp_nombre = $request->esp_nombre;

    	$especialidad->save();

    	return redirect('especialidades')->with('status', '¡Especialidad actualizada con exito!');

    }

    public function destroy($id){

    	$especialidad = Especialidades::findorFail($id);
    	$especialidad->delete();

    	return redirect()->route('especialidades.index')->with('destroyStatus', '¡Especialidad eliminada con exito!');

    }



}
