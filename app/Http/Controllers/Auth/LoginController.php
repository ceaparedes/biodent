<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Contracts\Validation\Validator;
use Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

//   use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
//    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
/*    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }
*/
    public function showLoginForm()
    {

        return view('auth.login');
    }

    public function username()
    {
        return 'usu_usuario';
    }

 
    public function login(Request $request){
        
        
        if ($request->username == NULL || $request->password == NULL){
           return redirect('/login')
                            ->withErrors('Debe Ingresar un Usuario y Contraseña');
        }
        $username = $request->username;
        $password = $request->password;
        
         
       
        if (Auth::attempt(['usu_usuario' => $username, 'password' => $password]) ) {
            return redirect('/dashboard');
            
               
            }else{
                return redirect('/login')
                            ->withErrors('Usuario o Contraseña Incorrectos')
                            ->withInput();
            }



    }   

    public function logout(){
        
        Auth::logout();

        return redirect('/login');
    }

}
