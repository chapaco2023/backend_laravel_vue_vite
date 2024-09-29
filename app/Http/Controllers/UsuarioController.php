<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UsuarioController extends Controller
{
    public function index()
    {
        /* select * from users
        el modelo User esta asociado a la tabla users*/
        $usuarios = User::get();
        //DB::select("");
        //table pivot
        //$table_pivot = DB::table("role_user")->get();
        // Query builder
        //$table_pivot = DB::table("role_user")->where("user_id", "=", 2)->first()->count()->last();
        //$table_pivot = DB::table("role_user")->join("users", "users.id", "role_user-user_id")->where("user_id", "=", 2)->count();
        return response()->json($usuarios, 200);
    }

    public function store(Request $request)
    {
        //Manejo de SQL
        //DB::insert("insert into users(name,email)values(?,?),[$request->name,$request->email]");
        //Manejo de Eloquent
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
