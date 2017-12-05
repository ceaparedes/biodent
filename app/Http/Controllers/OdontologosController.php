<?php

namespace App\Http\Controllers;

//use models
use App\Odontologos;
use App\Especialidades;

use Illuminate\Http\Request;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\Facades\DB;
use Malahierba\ChileRut\ChileRut;


class OdontologosController extends Controller
{
    
    public function create(){
    	$odontologo = new Odontologos();
    	$especialidades = new Especialidades();

    	return view('Odontologos.create')->with('odontologo',$odontologo);
    }

    public function store(request $request){


    }


}
