<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

//rutas pacientes
route::resource('pacientes','PacientesController');
route::get('pacientes/{id}/destroy',[
		'uses' =>'PacientesController@destroy',
		'as' => 'pacientes.destroy'
]);

//rutas odontologos
route::resource('odontologos', 'OdontologosController');

