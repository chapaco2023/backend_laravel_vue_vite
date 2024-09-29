<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
            'access_token' => $token,
            'usuario' => $usuario
        ], 201);
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
        $usuario->password = Hash::make($request->password);
        $usuario->save();
        //verificacion de cuenta
        event(new Registered($usuario));
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

    public function verify($user_id, Request $request)
    {
        if (!$request->hasValidSignature()) {
            return response()->json(['mensaje' => 'URL Expirado'], 401);
        }

        $user = User::findOrFail($user_id);

        if (!$user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
        }
        //enviar un mensaje en JSOn que el correo fue verificado
        return redirect()->to('/');
    }

    public function resend(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return response()->json(['message' => 'El Correo ya esta verificado'], 400);
        }
        $request->user()->sendEmailVerificationNotification();
        return response()->json(['message' => 'Se ha enviar un email de verifcacion']);
    }
}
