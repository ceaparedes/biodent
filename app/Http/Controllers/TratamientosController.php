<?php

namespace App\Http\Controllers;

//use models
use App\Tratamientos;
//use tools
use Illuminate\Http\Request;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\Facades\DB;


class TratamientosController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){

    	$tratamientos = Tratamientos::orderBy('tra_id','ASC')->paginate(10);
    	return view('tratamientos.index')->with('tratamientos', $tratamientos);
    }//end INDEX


    //create
    public function create(){
    	$tratamientos = new Tratamientos();
    	return view('tratamientos.create')->with('tratamientos', $tratamientos);
    }

    public function store(Request $request){
    	$this->validate($request,[
    		'tra_nombre'=>'required|regex:[^[a-zA-Z_áéíóúÁÉÍÓÚñ\s]*$]|min:3|max:100',
            'tra_costo_laboratorio'=>'integer|min:0|max:999999999',
    		'tra_costo'=>'required|integer|min:1|max:999999999'
    	]);

    	$tratamientos = new Tratamientos($request->all());
        if ($request->tra_costo_laboratorio == null) {
            $tratamientos->tra_costo_laboratorio = 0;
        }
    
    	$tratamientos->save();

    	return redirect('tratamientos')->with('status','¡El Tratamiento se ha creado con exito!');
    }

    public function edit($id){

    	$tratamientos = Tratamientos::findOrFail($id);

    	return view('tratamientos.edit')->with('tratamientos', $tratamientos);
    }


    public function update(Request $request, $id){
    	$this->validate($request,[
    		'tra_nombre'=>'required|regex:[^[a-zA-Z_áéíóúÁÉÍÓÚñ\s]*$]|min:3|max:100',
            'tra_costo_laboratorio'=>'integer|min:0|max:999999999',
    		'tra_costo'=>'required|integer|min:1|max:999999999'
    	]);

    	$tratamientos = Tratamientos::findOrFail($id);
    	$tratamientos->tra_nombre = $request->tra_nombre;
    	$tratamientos->tra_costo = $request->tra_costo;
        if ($request->tra_costo_laboratorio == Null) {
            $tratamientos->tra_costo_laboratorio = 0;
        }else{
            $tratamientos->tra_costo_laboratorio = $request->tra_costo_laboratorio;
        }

    	$tratamientos->save();

    	return redirect('tratamientos')->with('status','¡Tratamiento Actualizado con Exito!');
    }

    public function destroy($id){
    	$tratamientos = Tratamientos::findOrFail($id);
    	$tratamientos->delete();
    	return redirect()->route('tratamientos.index')->with('destroyStatus', '¡Tratamiento eliminado con exito!');
    }

}
