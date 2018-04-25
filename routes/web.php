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

/*Route::get('/', function () {
    return view('welcome');
});*/

//principio, pagina por defecto
Route::get('/dashboard', function(){
	return view('dashboard');
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
//editar Perfil
route::get('usuarios/{id}/editprofile',[
		'uses' => 'UsuariosController@editprofile',
		'as'=> 'usuarios.editprofile'
]);
route::put('usuarios/{id}/updateprofile',[
		'uses' => 'UsuariosController@updateprofile',
		'as' => 'usuarios.updateprofile',
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
//rutas autenticacion
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login')->middleware('guest');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');



