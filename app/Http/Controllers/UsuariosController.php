<?php

namespace App\Http\Controllers;
//use Laravel Models
use App\Usuarios;
use App\Especialidades;
use App\EspecialidadUsuario;
use App\Comuna;
//use Laravel tools
use Malahierba\ChileRut\ChileRut;
use Illuminate\Http\Request;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Hash;
use Auth;

class UsuariosController extends Controller
{

  public function __construct()
  {
      $this->middleware('auth');
  }

	public function index()
	{
    if (auth::user()->usu_rol == 'Administrador') {
      $usuarios = Usuarios::orderBy('usu_id','ASC')->paginate(10); 
       return view('usuarios.index')->with('usuarios', $usuarios);
    }else{

      return back()->with('destroyStatus', 'No tiene los permisos Necesarios para acceder a esa función');
    }
     

	}

    	
    public function create()
    {
      if (auth::user()->usu_rol == 'Administrador') {
         $usuario = new Usuarios();
         $comuna = Comuna::pluck('com_nombre', 'com_id');
         $especialidades = Especialidades::pluck('esp_nombre', 'esp_id');

         return view('usuarios.create')->with('usuario', $usuario)->with('comuna', $comuna)->with('especialidades', $especialidades);
      }else{
        return back()->with('destroyStatus', 'No tiene los permisos Necesarios para acceder a esa función');

      }

    }

    public function store(Request $request)
    {

      if (auth::user()->usu_rol == 'Administrador') {
          //validaciones
          $this->validate($request, [
            'usu_rut_completo' => 'required',
            'usu_nombres'=>'required|regex:[^[a-zA-Z_áéíóúÁÉÍÓÚñ\s]*$]|min:3|max:100',
            'usu_apellido_paterno'=>'required|regex:[^[a-zA-Z_áéíóúÁÉÍÓÚñ\s]*$]|min:3|max:100',
            'usu_apellido_materno'=>'required|regex:[^[a-zA-Z_áéíóúÁÉÍÓÚñ\s]*$]|min:3|max:100',
            'usu_direccion'=>'required|regex:[^[\sa-zA-Z0-9áéíóúAÉÍÓÚÑñ.,#:;-]+$]|min:3|max:200',
            'usu_telefono'=>'required|integer|min:111111111|max:99999999999',
            'usu_email'=> '|required|email',
            'usu_fecha_nacimiento'=>'required|date',
            'usu_usuario'=>'required',
            'usu_rol' => 'required',
            'com_id'=>'required',
          ]);
          
          $usuario = new Usuarios($request->all());

          $rut_completo = $request->usu_rut_completo;
          $chilerut = new ChileRut;
          if ($chilerut->check($rut_completo)) {
                //si el rut es correcto, se eliminan puntos y guion y se almacenan en inputs (pac_rut y pac_dv)
                $rut = explode('-', $rut_completo);
                $num_rut = intval(preg_replace('/[^0-9]+/', '', $rut[0]), 10);
                $usuario->usu_rut = $num_rut;
                $usuario->usu_dv = $rut[1];
          }else{
              //si el rut no es valido se devuelve el mensaje de error
               return redirect('usuarios/create')
                              ->withErrors('El RUT ingresado no es un rut valido')
                              ->withInput();
        }

        if($request->usu_rol == 'Asistente' && $request->esp_id != NUll){
            return redirect('usuarios/create')
                              ->withErrors('El Asistente no puede llevar Especialidad')
                              ->withInput();
        }

        $password = $request->usu_usuario;
        $usuario->usu_password = bcrypt($password);


        $usuario->save();

        if($request->esp_id != NULL){
          
          $usu_id = DB::table('usuarios')->where('usu_rut', $usuario->usu_rut)->value('usu_id');

          foreach ($request->esp_id as $esp) {
              $especialidad = new EspecialidadUsuario();
              $especialidad->esp_id = $esp;
              $especialidad->usu_id = $usu_id;
              $especialidad->save();
          }
         
        }

       
      return redirect('usuarios')->with('status', '¡Usuario creado con exito!');
    }else{
      return back()->with('destroyStatus', 'No tiene los permisos Necesarios para acceder a esa función');
    }


    }

    public function edit($id)
    {
      if (auth::user()->usu_rol == 'Administrador'){
        $usuario = Usuarios::findorFail($id);
        $usuario->usu_rut_completo = $usuario->usu_rut . "-". $usuario->usu_dv;

        $comuna = Comuna::pluck('com_nombre', 'com_id');
        $especialidad_usuario = DB::table('especialidad_usuario')->where('usu_id', $usuario->usu_id)->pluck('esp_id');
        $c = count($especialidad_usuario);
            if ($c == 1) {
              $especialidades = Especialidades::findOrFail($especialidad_usuario[0]);
            }
            elseif ($c > 1) {
              $i= 0;
              while($i != $c){
                $especialidades[$i] = Especialidades::findOrFail($especialidad_usuario[$i]);
                $i++;
              }
            }
            else{
              $especialidades = new Especialidades();
           
            }
         
        $esp = Especialidades::pluck('esp_nombre', 'esp_id');

        return view('usuarios.edit')->with('usuario',$usuario)->with('especialidades', $especialidades)->with('esp', $esp)->with('comuna', $comuna);
        }else{
          return back()->with('destroyStatus', 'No tiene los permisos Necesarios para acceder a esa función');
        }     
    }

    public function update(Request $request, $id)
    {
      if (auth::user()->usu_rol == 'Administrador'){
      //validaciones
        $this->validate($request, [
          'usu_rut_completo' => 'required',
          'usu_nombres'=>'required|regex:[^[a-zA-Z_áéíóúÁÉÍÓÚñ\s]*$]|min:3|max:100',
          'usu_apellido_paterno'=>'required|regex:[^[a-zA-Z_áéíóúÁÉÍÓÚñ\s]*$]|min:3|max:100',
          'usu_apellido_materno'=>'required|regex:[^[a-zA-Z_áéíóúÁÉÍÓÚñ\s]*$]|min:3|max:100',
          'usu_direccion'=>'required|regex:[^[\sa-zA-Z0-9áéíóúAÉÍÓÚÑñ.,#:;-]+$]|min:3|max:200',
          'usu_telefono'=>'required|integer|min:111111111|max:99999999999',
          'usu_email'=> '|required|email',
          'usu_fecha_nacimiento'=>'required|date',
          'usu_usuario'=>'required',
          'usu_rol' => 'required',
          'com_id'=>'required',
        ]);

        $usuario = Usuarios::findOrFail($id);
        $usuario->usu_nombres = $request->usu_nombres;
        $usuario->usu_apellido_paterno = $request->usu_apellido_paterno;
        $usuario->usu_apellido_materno = $request->usu_apellido_materno;
        $usuario->usu_fecha_nacimiento = $request->usu_fecha_nacimiento;
        $usuario->usu_direccion = $request->usu_direccion;
        $usuario->com_id = $request->com_id;
        $usuario->usu_email = $request->usu_email;
        $usuario->usu_telefono = $request->usu_telefono;

        $rut_completo = $request->usu_rut_completo;
        $chilerut = new ChileRut;
        if ($chilerut->check($rut_completo)) {
              //si el rut es correcto, se eliminan puntos y guion y se almacenan en inputs (pac_rut y pac_dv)
              $rut = explode('-', $rut_completo);
              $num_rut = intval(preg_replace('/[^0-9]+/', '', $rut[0]), 10);
              $usuario->usu_rut = $num_rut;
              $usuario->usu_dv = $rut[1];
        }else{
            //si el rut no es valido se devuelve el mensaje de error
             return redirect()->route('usuarios.edit', ['id' => $id])
                            ->withErrors('El RUT ingresado no es un rut valido')
                            ->withInput();
      }

      if($request->usu_rol == 'Asistente' && $request->esp_id != NUll){
          return redirect()->route('usuarios.edit', ['id' => $id])
                            ->withErrors('El Asistente no puede llevar Especialidad')
                            ->withInput();
      }

      if ($request->usu_password == $request->usu_confirmar_password && $request->usu_password != NULL && $request->usu_confirmar_password != NULL ) {
          
          $password = $request->usu_password;
          $usuario->usu_password = bcrypt($password);

      }elseif ($request->usu_password != $request->usu_confirmar_password) {
          return redirect()->route('usuarios.edit', ['id' => $id])
                            ->withErrors('Las Contraseñas no coinciden')
                            ->withInput();
      }

      $usuario->save();

      $esu_id_anteriores =  DB::table('especialidad_usuario')->where('usu_id', $id)->pluck('esu_id');
      $count_esu_anteriores = count($esu_id_anteriores);
      $count_new_esu = count($request->esp_id);
      
      //si ambos son 0 no se hace nada
      if ($count_esu_anteriores == 0 && $count_new_esu == 0) {
         return redirect('usuarios')->with('status', 'Usuario Actualizado con exito!');
      }//si existen nuevos amg, se insertan como si nada
      elseif ($count_esu_anteriores == 0 && $count_new_esu >0) {
          $i= 0;
          while($i < $count_new_esu){
            $especialidad = new EspecialidadUsuario();
            $especialidad->usu_id = $id;
            $especialidad->esp_id = $request->esp_id[$i];
            $especialidad->save();
            $i++;
          }

      }//si no existen nuevos amg, pero existen anteriores, estos se eliminan
      elseif ($count_esu_anteriores > 0 && $count_new_esu == 0) {
          DB::table('especialidad_usuario')->where('usu_id', $id)->delete();
      }
      elseif ($count_esu_anteriores > $count_new_esu) {
          $i = 0;
          $suma = $count_esu_anteriores + $count_new_esu - 1;
          while($i < $count_new_esu){
            $especialidad = EspecialidadUsuario::findOrFail($esu_id_anteriores[$i]);
            $especialidad->esp_id = $request->esp_id[$i];
            $especialidad->save();
            $i++;
          }
          while ($i < $suma) {
            $especialidad = EspecialidadUsuario::findOrFail($esu_id_anteriores[$i]);
            $especialidad->delete();
            $i++;
          }

      }
      elseif ($count_esu_anteriores < $count_new_esu) {
          $i = 0;
          $suma = $count_esu_anteriores + $count_new_esu -1 ;
          while($i < $count_esu_anteriores){
            $especialidad = EspecialidadUsuario::findOrFail($esu_id_anteriores[$i]);
            $especialidad->esp_id = $request->esp_id[$i];
            $especialidad->save();
            $i++;
          }
          while ($i < $suma) {
            $especialidad = new EspecialidadUsuario();
            $especialidad->usu_id = $id;
            $especialidad->esp_id = $request->esp_id[$i];
            $especialidad->save();
            $i++;
          }

      }
      elseif ($count_esu_anteriores == $count_new_esu && $count_esu_anteriores >0) {
          $i = 0;
          while($i < $count_esu_anteriores){
            $especialidad = EspecialidadUsuario::findOrFail($esu_id_anteriores[$i]);
            $especialidad->esp_id = $request->esp_id[$i];
            $especialidad->save();
            $i++;
          }

      }     

      return redirect('usuarios')->with('status', 'Usuario Actualizado con exito!');
    }else{
      return back()->with('destroyStatus', 'No tiene los permisos Necesarios para acceder a esa función');
    }
  }

  public function destroy($id)
  {
    if (auth::user()->usu_rol == 'Administrador'){
      $usuario = Usuarios::findorFail($id);
      $especialidades = DB::table('especialidad_usuario')->where('usu_id', $id)->get();
      if ($especialidades) {
        DB::table('especialidad_usuario')->where('usu_id', $id)->delete();
      }

      $usuario->delete();

      return redirect()->route('usuarios.index')->with('destroyStatus', 'Usuario eliminado con exito!');
    }else{
      return back()->with('destroyStatus', 'No tiene los permisos Necesarios para acceder a esa función');
    }
  } 

  public function show($id)
  {
    if (auth::user()->usu_rol == 'Administrador'){
      $usuario = Usuarios::findOrFail($id);
      $usuario->usu_rut_completo = $usuario->usu_rut . '-' . $usuario->usu_dv;
      $comuna = Comuna::findOrFail($usuario->com_id);

      $esp_usu= DB::table('especialidad_usuario')->where('usu_id', $id)->pluck('esp_id');
      if ($esp_usu != NULL) {
         $especialidades= DB::table('especialidades')->whereIn('esp_id', $esp_usu)->pluck('esp_nombre');
      }else{
        $especialidades = NULL;
      }
      
      return view('usuarios.show')->with('usuario',$usuario)->with('especialidades', $especialidades)->with('comuna', $comuna);
    }else{
      return back()->with('destroyStatus', 'No tiene los permisos Necesarios para acceder a esa función');
    }
    
  }

    public function editprofile($id)
    {
      if (auth::user()->usu_id == $id) {
       $usuario = Usuarios::findorFail($id);
        $usuario->usu_rut_completo = $usuario->usu_rut . "-". $usuario->usu_dv;

        $comuna = Comuna::pluck('com_nombre', 'com_id');
        $esp_usu= DB::table('especialidad_usuario')->where('usu_id', $id)->pluck('esp_id');
        if ($esp_usu != NULL) {
         $especialidades= DB::table('especialidades')->whereIn('esp_id', $esp_usu)->pluck('esp_nombre');
        }else{
          $especialidades = NULL;
        }
      
        return view('usuarios.editprofile')->with('usuario',$usuario)->with('especialidades', $especialidades)->with('comuna', $comuna);
      }else{
        return back()->with('destroyStatus', 'No tiene los permisos Necesarios para acceder a esa función');
      }
      

    }

    public function updateprofile($id, Request $request)
    {
      
      if(hash::check($request->usu_password, Auth::user()->usu_password)){
        
        $this->validate($request, [
          'usu_rut_completo' => 'required',
          'usu_nombres'=>'required|regex:[^[a-zA-Z_áéíóúÁÉÍÓÚñ\s]*$]|min:3|max:100',
          'usu_apellido_paterno'=>'required|regex:[^[a-zA-Z_áéíóúÁÉÍÓÚñ\s]*$]|min:3|max:100',
          'usu_apellido_materno'=>'required|regex:[^[a-zA-Z_áéíóúÁÉÍÓÚñ\s]*$]|min:3|max:100',
          'usu_direccion'=>'required|regex:[^[\sa-zA-Z0-9áéíóúAÉÍÓÚÑñ.,#:;-]+$]|min:3|max:200',
          'usu_telefono'=>'required|integer|min:111111111|max:99999999999',
          'usu_email'=> '|required|email',
          'usu_fecha_nacimiento'=>'required|date',
          'usu_usuario'=>'required',
          'usu_rol' => 'required',
          'com_id'=>'required',

        ]);

        $usuario = Usuarios::findOrFail($id);
        $usuario->usu_nombres = $request->usu_nombres;
        $usuario->usu_apellido_paterno = $request->usu_apellido_paterno;
        $usuario->usu_apellido_materno = $request->usu_apellido_materno;
        $usuario->usu_fecha_nacimiento = $request->usu_fecha_nacimiento;
        $usuario->usu_direccion = $request->usu_direccion;
        $usuario->com_id = $request->com_id;
        $usuario->usu_email = $request->usu_email;
        $usuario->usu_telefono = $request->usu_telefono;

        $rut_completo = $request->usu_rut_completo;
        $chilerut = new ChileRut;
        if ($chilerut->check($rut_completo)) {
              //si el rut es correcto, se eliminan puntos y guion y se almacenan en inputs (pac_rut y pac_dv)
              $rut = explode('-', $rut_completo);
              $num_rut = intval(preg_replace('/[^0-9]+/', '', $rut[0]), 10);
              $usuario->usu_rut = $num_rut;
              $usuario->usu_dv = $rut[1];
        }else{
            //si el rut no es valido se devuelve el mensaje de error
             return redirect()->route('usuarios.editprofile', ['id' => $id])
                            ->withErrors('El RUT ingresado no es un rut valido')
                            ->withInput();
      }

      if ($request->usu_new_password == $request->usu_confirmar_password && $request->usu_new_password != NULL && $request->usu_confirmar_password != NULL ) {
          
          $password = $request->usu_new_password;
          $usuario->usu_password = bcrypt($password);

      }elseif ($request->usu_password != $request->usu_confirmar_password) {
          return redirect()->route('usuarios.editprofile', ['id' => $id])
                            ->withErrors('Las Contraseñas no coinciden')
                            ->withInput();
      }

      $usuario->save();
      return redirect('/dashboard')->with('status', '¡Perfil Actualizado Con Exito!');

      }else{
        return redirect()->route('usuarios.editprofile', ['id' => $id])
                            ->withErrors('Contraseña Actual Incorrecta')
                            ->withInput();
      }

    }

}
