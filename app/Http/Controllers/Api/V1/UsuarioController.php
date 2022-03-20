<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterPostRequest;
use DB;
use JWTAuth;

class UsuarioController extends Controller
{
    protected $user;

    public function __construct()
    {
        $this->user = JWTAuth::parseToken()->authenticate();
    }

    public function createUser(Request $request)
    {
        DB::insert(
            'INSERT into users (name, email, password, role, status) values (?, ?, ?, ?, ?)',
            [$request->name, $request->email, bcrypt($request->password), 'usuario', '1']
        );


        return response()->json([
            'success' => true,
            'message' => $request->name,
        ], 201);
    }

    public function listUser()
    {

        $usuarios = DB::select('SELECT *, @n := @n + 1 n from users, (SELECT @n := 0) m where role = "usuario"');


        return response()->json($usuarios);
    }

    public function editUser($id)
    {

        $usuario = DB::select('SELECT id, name, email from users where id = "'.$id.'" AND role = "usuario"');


        return response()->json($usuario);
    }

    public function actualizarUser(Request $request)
    {
        if($request->password == null){
            DB::update('UPDATE users SET name = ?, email = ? WHERE id = ?', [$request->name, $request->email, $request->id]);
        }else {
            DB::update('UPDATE users SET name = ?, email = ?, password = ? WHERE id = ?', [$request->name, $request->email, bcrypt($request->password), $request->id]);
        }

        return response()->json([
            'success' => true,
            'message' => "Usuario actualizado correctamente",
        ], 201);
    }

    public function eliminarUser($id)
    {

         DB::select('DELETE from users WHERE id = "'.$id.'"');

        return response()->json([
            'success' => true,
            'message' => 'Usuario eliminado correctamente',
        ], 201);
    }

}
