<?php

namespace App\Http\Controllers;

use App\Http\Requests\UsuarioRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    public function index()
    {
        $usuarios = User::get();
        return response()->json($usuarios, 200);
    }

    public function store(UsuarioRequest $request)
    {
        $usuario = new User();
        $usuario->name = $request->name;
        $usuario->email = $request->email;
        $usuario->password = $request->password;
        $usuario->save();
        return response()->json(["message" => "Usuario Registrado"]);
    }

    public function show(string $id)
    {
        $usuario = User::find($id);
        if (!$usuario) {
            return response()->json(["message" => "Usuario no encontrado"], 404);
        }
        return response()->json($usuario, 200);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,$id',
            'password' => 'required'
        ]);
        $usuario = User::find($id);
        $usuario->name = $request->name;
        $usuario->email = $request->email;
        $usuario->password = $request->password;
        $usuario->update();
        return response()->json(["message" => "Usuario Actualizado"]);
    }

    public function destroy(string $id)
    {
        $usuario = User::find($id);
        if (!$usuario) {
            return response()->json(["message" => "Usuario no encontrado"], 404);
        }
        $usuario->delete();
        return response()->json(["message" => "Usuario Eliminado"]);
    }
}
