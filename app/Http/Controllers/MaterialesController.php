<?php

namespace App\Http\Controllers;
//use Models
use App\Materiales;
//use Laravel Tools
use Illuminate\Http\Request;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

class MaterialesController extends Controller
{
    public function __construct()
  	{
      $this->middleware('auth');
  	}

    public function index()
    {
        $materiales = Materiales::orderBy('mat_id','ASC')->paginate(10);

         return view('materiales.index')->with('materiales',$materiales); 

    }

    public function create()
    {
    	return view('materiales.create');
    }

    public function store(request $request)
    {

    	$this->validate($request, [
        'mat_codigo' => 'required|numeric',
        'mat_nombre_material'=>'required',
        'mat_costo'=>'required|numeric|min:1',
        'mat_stock'=>'required|numeric|min:1',
        'mat_stock_minimo'=>'required|min:1',
        'mat_estado'=>'required',
      ]); 

    	$material = new Materiales($request->all());
        $material->mat_fecha_creacion = date('Y-m-d');
        $material->mat_fecha_actualizacion = date('Y-m-d');
        $material->save();
        return redirect('materiales')->with('status', '¡Material creado con exito!');
        
    }

    public function edit($id)
    {

        $material = Materiales::findorFail($id);
        return view('materiales.edit')->with('material', $material);

    }

    public function update($id, request $request)
    {
        $this->validate($request, [
        'mat_codigo' => 'required|numeric',
        'mat_nombre_material'=>'required',
        'mat_costo'=>'required|numeric|min:1',
        'mat_stock'=>'required|numeric|min:1',
        'mat_stock_minimo'=>'required|min:1',
        'mat_estado'=>'required',
      ]); 

        $material = Materiales::findorFail($id);
        $material->mat_codigo = $reques->mat_codigo;
        $material->mat_nombre_material = $reques->mat_nombre_material;
        $material->mat_costo = $reques->mat_costo;
        $material->mat_stock = $reques->mat_stock;
        $material->mat_stock_minimo = $reques->mat_stock_minimo;
        $material->mat_estado = $reques->mat_estado;
        $material->mat_fecha_actualizacion = $reques->mat_fecha_actualizacion;

        $material->save();

        return redirect('materiales')->with('status', '¡Material Actualizado con exito!');
    }

    //destroy
  public function destroy($id){

    $materiales = Materiales::findOrFail($id);
    //query para eliminar todos los elementos, en base al id entregado
    DB::table('material_sesion')->where('mat_id', $id)->delete();
    DB::table('recepciones_materiales')->where('mat_id', $id)->delete();
    $materiales->delete();

    return redirect()->route('materiales.index')->with('destroyStatus', 'Paciente eliminado con exito!');
    
  }//end destory



}
