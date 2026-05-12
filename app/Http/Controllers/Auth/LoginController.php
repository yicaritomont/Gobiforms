<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Redirect;
use Illuminate\Http\Request;

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

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Function to process request authenticate.
     */
    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Authentication passed...
            return redirect()->intended('dashboard');
        }
    }
    public function login(Request $request)
    {
        if(!isset($_POST['email']))
        {
            $_POST['email'] = $_POST['username'];
        }
        // before login , first validate if a email exists
        $data = [
            'document'     => $_POST['email'],
            'password'   =>  $_POST['password']
        ];
        
        if ( !$user = User::where('document',$_POST['email'])->first())
        {
            // return a fail user
            return Redirect::to('login/')->with(['message'=> 'Error! No se puede iniciar sesión, verifique e intente','alert'=> 'danger']);
        }
        else
        {
            if (!Auth::attempt($data))
            {
                // Send a incorrect password
                return Redirect::to('login/')->with(['message'=> 'No se puede iniciar sesión, su información es incorrecta, verifique e intente más tarde.','alert'=> 'danger']);
            }
            else
            {
                //TODO DEJAR EN !empty- cuando se solucione correo envio.
                if(empty($user->email_verified_at) && $user->rol_id != 1) {
                    Auth::logout();
                    return Redirect::to('login/')->with(['message'=> 'Cuenta no verificada,revise su bandeja de entrada o Spam. Si no recibio validación, solicitela de nuevo','alert'=> 'info']);
                }
                else
                {
                    if($user->rol_id == "1") {
                        // es administrador muestre dashboard principal
                        return redirect('dashBoardAdmin');
                    }
                    else {
                        // es un usuario normal dashboard de usuario
                        return redirect('dashBoardUser');
                    
                    }
                }
            }
        }

    }

    public function logout(){
        // cierra sesion y devuelve al login 
        Auth::logout();
        return redirect('/');
    }
}
