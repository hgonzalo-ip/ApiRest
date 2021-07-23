<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use Carbon\Carbon;
class AuthController extends Controller
{
    public function Register(Request $request){
        $request->validate([
            'IdTipoUsuario' => 'required|integer',
            'email' => 'required|email|string|unique:users',
            'password' => 'required|string|min:5'
            
        ]);

        User::create([
            'IdTipoUsuario' => $request->IdTipoUsuario,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'Estado' => 1 
        ]);

        return response()->json([
            'message' => 'Usuario Creado Correctamente'
        ], 201);
    }

    public function Login(Request $request){
        $request->validate([            
            'email' => 'required|email|string',
            'password' => 'required|string|min:5',
            'remember_me' => 'boolean'            
        ]);

        $credentials = request([ 'email','password' ]);

        if(!Auth::attempt($credentials)){
            return response()->json([
                'message' => 'Usuario No Autorizado'
            ], 401);
        }

        $user = $request->user();
        $tokenResult = $user->createToken('Token Personal de accesso');
        $IdTipo = $user->IdTipoUsuario;
        $IdUsuario = $user->IdUsuario;
        $token = $tokenResult->token;

        if($request->remember_me){
            $token->expires_at = Carbon::now('America/Guatemala')->addDays(1);            
            $token->save();
        }

        return response()->json([
            'IdUsuario' => $IdUsuario,
            'IdTipoUsuario' => $IdTipo,
            'acces_token' =>  $tokenResult->accessToken,
            'Token_type' => 'Bearer',
            'expires_at' => Carbon::parse($token->expires_at)->toDateTimeString()
        ]);
    }

    public function Logout(Request $request){

        $request->user()->token()->delete();

        return response()->json([
            'message' => 'Sesion Cerrada Correctamente'
        ]);
    }
    public function user(Request $request){
        $Id = $request->user();
        $IdUser = $Id->IdUsuario;

        $User = User::find($IdUser);
        $UserFormato = array();
        $UserNew = [];
   
            $UserFormato['IdUsuario'] = $IdUser;
            $UserFormato['IdTipoUsuario'] = $User->IdTipoUsuario;
            $UserFormato['email'] = $User->email;
            $UserFormato['IdSucursal'] = $User->DecEmpleado[0]->IdSucursal;
            $UserFormato['Sucursal'] = $User->DecEmpleado[0]->Sucursal->NombreSucursal;
            
            array_push($UserNew, $UserFormato);
     
        return response()->json($UserNew, 200);
    }
}
