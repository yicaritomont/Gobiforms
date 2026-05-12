<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Helpers\Equivalencias;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Redirect;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all()->map(function($user) {
        $user->size_label = Equivalencias::whichZone($user->size_organization);
        return $user;
         });
        return view("user.index", compact("users"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = new User;
        $isAdmin = true;
        return view("user.create", compact("user","isAdmin"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
            'name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
            ]);
            // Crea el codigo de confirmación
            $confirmation_code = RegisterController::generateRandom($request['email']);
            $user = new User();
            $user->name = $request['name'];
            $user->last_name = $request['last_name'];
            $user->email = $request['email'];
            $user->phone_number = $request['phone_number'];
            $user->size_organization = $request['size_organization'];
            $user->name_organization = $request['name_organization'];
            $user->password              = Hash::make($request['password']);
            $user->rol_id = 2;
            $user->confirmation_code     = $confirmation_code;
            $user->email_verified_at = now();
            
        if ($user->save()) {
            $datos= array(
                'nombre_persona'    => $request->name." ".$request->last_name,
                'usuario'			=> $request->email,
                'contrasena'		=> $request->password,
                'perfil'			=> 'Usuario' ,
                'confirmation_code' => $confirmation_code,
                'subject'           => 'Registro Usuario',               
                'email' => $request->email,
                'name'  =>'USUARIO'
            );
            //RegisterController::sendMailRegister($datos,$user,'emails.register');
            //Sendemail::Send($datos,'emails.register');

            $mensaje = 'Se ha registrado un nuevo usuario con el correo '.$request['email'].' exitosamente.';
            
        } 
        else 
        {
            $mensaje =  "No se puede registrar";
        } 
        return Redirect::to('users/')->with(['message'=> $mensaje,'alert'=> 'info']);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        return view('user.edit',compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        //
        $validateData = $request->validate([
            'name'=>'required|max:255|unique:user,name,' .$id,            
        ], [
            'name.required' => "El nombre es requerido",
            'name.unique'   => "Ya existe un rol con este nombre"]);    
        $user = User::find($id)->update($request->all());
        return redirect()->route('user.index')->with('success', 'Rol actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function rolUpdateStatus($id)
    {
        $user = User::find($id);
     
        switch ($user->status) {
            case 1:
                $newStatus = 2;
                $text  = "Inactivado";
                break;
            case 2:
                $newStatus = 1;
                $text = "Activado";
                break;
            default:
                $status = 1;
                $text = "Activado";
                break;
        }
        $user->update(["status"=> $newStatus]);
        return redirect()->route('user.index')->with('success','Usuario ' . $text . ' correctamente');
    }
}
