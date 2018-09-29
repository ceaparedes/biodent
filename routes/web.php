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


//rutas planes de tratamientos
route::get('planes-de-tratamientos/{pac_id}/create',[
			'uses'=> 'PlanesDeTratamientosController@create',
			'as' => 'planes-de-tratamientos.create'

]);
route::post('planes-de-tratamientos/{pac_id}/store',[
			'uses'=> 'PlanesDeTratamientosController@store',
			'as' => 'planes-de-tratamientos.store'

]);

route::get('planes-de-tratamientos/cancelar_plan/{pdt_id}',[
			'uses'=> 'PlanesDeTratamientosController@cancelar_plan',
			'as' => 'planes-de-tratamientos.cancelar_plan'

]);

route::get('planes-de-tratamientos/finalizar_plan/{pdt_id}',[
			'uses'=> 'PlanesDeTratamientosController@finalizar_plan',
			'as' => 'planes-de-tratamientos.finalizar_plan'

]);

route::get('planes-de-tratamientos/generar_pdf/{pdt_id}',[
			'uses'=> 'PlanesDeTratamientosController@generar_pdf',
			'as' => 'planes-de-tratamientos.generar_pdf'

]);

route::get('planes-de-tratamientos/{pac_id}/pacienteindex',[
			'uses'=> 'PlanesDeTratamientosController@pacienteindex',
			'as' => 'planes-de-tratamientos.pacienteindex'

]);

Route::get('/planes-de-tratamientos/', [
	'uses' => 'PlanesDeTratamientosController@index',
	'as' => 'planes-de-tratamientos.index'
]);

route::get('planes-de-tratamientos/{id}/edit',[
			'uses'=> 'PlanesDeTratamientosController@edit',
			'as' => 'planes-de-tratamientos.edit'

]);

route::put('planes-de-tratamientos/{pac_id}/update',[
			'uses'=> 'PlanesDeTratamientosController@update',
			'as' => 'planes-de-tratamientos.update'

]);

route::get('planes-de-tratamientos/{id}/destroy',[
			'uses'=> 'PlanesDeTratamientosController@destroy',
			'as' => 'planes-de-tratamientos.destroy'

]);

route::get('planes-de-tratamientos/{id}/show',[
			'uses'=> 'PlanesDeTratamientosController@show',
			'as' => 'planes-de-tratamientos.show'

]);
//end rutas planes de tratamientos

//rutas Materiales
route::resource('materiales','MaterialesController');
route::get('materiales/{id}/destroy',[
		'uses' =>'MaterialesController@destroy',
		'as' => 'materiales.destroy'
]);

//rutas Recepciones Materiales
route::get('recepciones-materiales/{mat_id}/index',[
			'uses'=> 'RecepcionesMaterialesController@index',
			'as' => 'recepciones-materiales.index'
]);

route::get('recepciones-materiales/{mat_id}/create',[
			'uses'=> 'RecepcionesMaterialesController@create',
			'as' => 'recepciones-materiales.create'
]);

route::post('recepciones-materiales/{mat_id}/store',[
			'uses'=> 'RecepcionesMaterialesController@store',
			'as' => 'recepciones-materiales.store'
]);

//rutas abonos Tratamientos
route::get('abonos-tratamientos/{pdt_id}/',[
			'uses'=> 'AbonosTratamientosController@index',
			'as' => 'abonos-tratamientos.index'

]);

route::get('abonos-tratamientos/{pdt_id}/create',[
			'uses'=> 'AbonosTratamientosController@create',
			'as' => 'abonos-tratamientos.create'

]);

route::post('abonos-tratamientos/{pdt_id}/store',[
			'uses'=> 'AbonosTratamientosController@store',
			'as' => 'abonos-tratamientos.store'
]);

route::get('abonos-tratamientos/{id}/destroy',[
			'uses'=> 'AbonosTratamientosController@destroy',
			'as' => 'abonos-tratamientos.destroy'
]);
//end rutas abonos
//rutas sesiones ejecucion Tratamiento

route::get('sesiones-ejecucion-tratamientos/{pdt_id}/',[
			'uses'=> 'SesionesEjecucionTratamientosController@index',
			'as' => 'sesiones-ejecucion-tratamientos.index'

]);

route::get('sesiones-ejecucion-tratamientos/{pdt_id}/create',[
			'uses'=> 'SesionesEjecucionTratamientosController@create',
			'as' => 'sesiones-ejecucion-tratamientos.create'

]);

route::post('sesiones-ejecucion-tratamientos/consultar_stock',[
			'uses'=> 'SesionesEjecucionTratamientosController@consultar_stock',
			'as' => 'sesiones-ejecucion-tratamientos.consultar_stock'

]);

route::post('sesiones-ejecucion-tratamientos/buscar_pieza',[
			'uses'=> 'SesionesEjecucionTratamientosController@buscar_pieza',
			'as' => 'sesiones-ejecucion-tratamientos.buscar_pieza'

]);

route::post('sesiones-ejecucion-tratamientos/{pdt_id}/store',[
			'uses'=> 'SesionesEjecucionTratamientosController@store',
			'as' => 'sesiones-ejecucion-tratamientos.store'

]);

route::get('sesiones-ejecucion-tratamientos/{pdt_id}/index',[
			'uses'=> 'SesionesEjecucionTratamientosController@index',
			'as' => 'sesiones-ejecucion-tratamientos.index'

]);

route::get('sesiones-ejecucion-tratamientos/{id}/destroy',[
			'uses'=> 'SesionesEjecucionTratamientosController@destroy',
			'as' => 'sesiones-ejecucion-tratamientos.destroy'

]);

route::get('sesiones-ejecucion-tratamientos/{id}/show',[
			'uses'=> 'SesionesEjecucionTratamientosController@show',
			'as' => 'sesiones-ejecucion-tratamientos.show'
]);
