<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function funLogin(Request $request)
    {
        //validar
        $credenciales = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        //Autentificacion
        if (!Auth::attempt($credenciales)) {
            return response()->json(['message' => 'Credenciales Incorrectas'], 401);
        }
        //obtenet el usuario autentifcado
        $usuario = $request->user();
        $token = $usuario->createToken('Token auth')->plainTextToken;
        //respondemos
        return response()->json([
            'acces_token' => $token,
            'usuario' => $usuario
        ]);
    }

    public function funRegister(Request $request)
    {
        //validar
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|same:c_password',
        ]);
        //guardar
        $usuario = new User();
        $usuario->name = $request->name;
        $usuario->email = $request->email;
        $usuario->password = $request->password;
        $usuario->save();
        //verificacion de cuenta
        //generar una respuesta
        return response()->json(['message' => 'Usuario Registrado'], 201);
    }

    public function funProfile(Request $request)
    {
        //Obtener el usuario autentificado
        $usuario = $request->user();
        return response()->json($usuario);
    }
    public function funLogout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json(['message' => 'Logout']);
    }
}
