<?php

namespace App\Http\Controllers;
//use laravel models
use App\Materiales;
use App\RecepcionesMateriales;
//use tools
use Illuminate\Http\Request;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

class RecepcionesMaterialesController extends Controller
{

    public function __construct()
    {
      $this->middleware('auth');
    }


    public function index($mat_id)
    {
        //dd("vacio por ahora");
        $recepciones = RecepcionesMateriales::where('mat_id', $mat_id)->orderBy('rep_id','DESC')->paginate(10);
        $material = Materiales::findorFail($mat_id);
        return view('recepciones-materiales.index')->with('recepciones', $recepciones)->with('material', $material);
    }

    public function create($mat_id)
    {
        $material = Materiales::findorFail($mat_id);
        return view('recepciones-materiales.create')->with('material', $material);

    }

    public function store(request $request, $mat_id)
    {
        $this->validate($request, [
        'rep_codigo' => 'required|numeric',
        'rep_proveedor'=>'required',
        'rep_cantidad'=>'required|numeric|min:1',
        'rep_monto' => 'required|min:1'
      ]); 
        $material = Materiales::findorFail($mat_id);
        $recepcion = new RecepcionesMateriales($request->all());
        $recepcion->mat_id = $mat_id;
        $recepcion->rep_fecha_compra = date('Y-m-d');
        $material->mat_stock = $material->mat_stock + $request->rep_cantidad;
        $material->mat_costo = $request->rep_monto;
        $material->save();
        $recepcion->save();
        return redirect()->route('recepciones-materiales.index', ['id' => $mat_id])->with('status', '¡Plan eliminado con exito!');
    }

}
