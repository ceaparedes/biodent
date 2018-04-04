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

//rutas Usuarios
route::resource('usuarios', 'UsuariosController');
route::get('usuarios/{id}/destroy',[
			'uses'=> 'UsuariosController@destroy',
			'as' => 'usuarios.destroy'

]);

//Rutas Especialidades
route::resource('especialidades', 'EspecialidadesController');
route::get('especialidades/{id}/destroy',[
			'uses'=> 'EspecialidadesController@destroy',
			'as' => 'especialidades.destroy'

]);

//rutas Tratamientos
route::resource('tratamientos', 'TratamientosController');
route::get('tratamientos/{id}/destroy',[
			'uses'=> 'tratamientosController@destroy',
			'as' => 'tratamientos.destroy'

]);