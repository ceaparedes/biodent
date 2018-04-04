<?php

namespace App\Http\Controllers;
//use Laravel Models
use App\Usuarios;
use App\Especialidades;
use App\Comuna;
//use Laravel tools
use Malahierba\ChileRut\ChileRut;
use Illuminate\Http\Request;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

class UsuariosController extends Controller
{

	public function index()
	{


	}

    	
    public function create()
    {
    	$usuario = new Usuarios();
        $comuna = Comuna::pluck('com_nombre', 'com_id');
        $especialidades = Especialidades::pluck('esp_nombre', 'esp_id');

        return view('usuarios.create')->with('usuario', $usuario)->with('comuna', $comuna)->with('especialidades', $especialidades);

    }

    public function store()
    {



    }

    public function edit()
    {


    }

    public function update()
    {


    }

    public function destroy()
    {


    }

    public function show()
    {


    }


}
