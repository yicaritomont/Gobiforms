<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Services\Sendemail;
use App\Http\Helpers\Equivalencia;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Mail;
use Redirect;

class RegisterController extends Controller {
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'document' => ['required', 'string', 'max:255', 'unique:users'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'document' => $data['document'],
        ]);
    }

    public function register(Request $request) {
        $mensaje="paila no hizo nada";
        $this->validate($request, [
            'document' => ['required', 'string', 'max:255', 'unique:users'],
            'name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
            ]);
            // Crea el codigo de confirmación
            $confirmation_code = RegisterController::generateRandom($request['email']);
            $user = new User();
            $user->name = $request['name'];
            $user->last_name = $request['last_name'];
            $user->document = $request['document'];
            $user->email = $request['email'];
            $user->phone_number = $request['phone_number'];
            $user->size_organization = $request['size_organization'];
            $user->name_organization = $request['name_organization'];
            $user->password              = Hash::make($request['document']);
            $user->rol_id = 2;
            $user->confirmation_code     = $confirmation_code;
            $user->email_verified_at = now();
            
        if ($user->save()) {
            $datos= array(
                'nombre_persona'    => $request->name." ".$request->last_name,
                'usuario'			=> $request->document,
                'contrasena'		=> $request->document,
                'perfil'			=> 'Usuario' ,
                'confirmation_code' => $confirmation_code,
                'subject'           => 'Registro Usuario',               
                'email' => $request->email,
                'name'  =>'USUARIO'
            );
            //RegisterController::sendMailRegister($datos,$user,'emails.register');
            //Sendemail::Send($datos,'emails.register');

            $mensaje = 'Se ha registrado un nuevo usuario con el documento '.$request['document'].' exitosamente.';
            
        } 
        else 
        {
            $mensaje =  "No se puede registrar";
        } 
    
        return Redirect::to('login/')->with(['message'=> $mensaje,'alert'=> 'info']);

    }
    
    public static function generateRandom($info)
    {
        return hash('sha256', $info);
    }

    
    public static function sendMailRegister($datos,$user,$plantilla)
    {
        Mail::send($plantilla, array('datos'=>$datos), function($message) use ($datos ,$user)
        {
            $message->to($user['email'], $user['name'])->subject('Registro Usuario');
        });  
    }
}
