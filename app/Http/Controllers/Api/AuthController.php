<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\RegisterUserRequest;

class AuthController extends Controller
{
    //Inicio de sesión
    public function login(Request $request){
        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];

        // Si la autenticación es correcta genera el token.
        if (Auth::attempt($credentials)) {
            // Consulta los datos del usuario con ese email
            $usuario = User::where('email', '=', $request->email)->first();
            // Verificar si la cuenta está habilitada (enabled = 1)
            if ($usuario->enable == 0) {
                return response()->json(['message' => 'La cuenta está eliminada o deshabilitada.'], 403);
            }
            // Genera el token para la sesión
            $token = Auth::user()->createToken('myapptoken')->plainTextToken;
            // Añadir los datos del usuario
            $collect[0] = array(
                "user_id" => $usuario->id,
                "token" => $token,
                "name" => $usuario->name,
                "phone" => $usuario->phone,
                "email" => $usuario->email
            );

            return response()->json($collect);
        } else {
            return response()->json(['message' => 'Credenciales Incorrectas'], 401);
        }
    }

    //Cerrar sesión
    public function logout(Request $request){
        // Remueve el token
        $request->user()->tokens()->delete();
        return response()->json([
            'message' => 'Sesión cerrada correctamente'
        ], 200);
    }

    //Registrar usuario
    /*
        Si el usuario que hace la petición no está autenticado o no es admin, el role siempre se asigna como "user" aunque envíen otro rol.
        Si es admin, puede enviar role "admin" o "user", si no envía rol, se asume "user".
    */
    public function register(RegisterUserRequest $request){
        $data = $request->validated();
        $authUser = auth('sanctum')->user();
        $role = $data['role'] ?? 'user';
        if (!$authUser || $authUser->role !== 'admin' || !in_array($role, ['admin', 'user'])) {
            $role = 'user';
        }
        $data['role'] = $role;
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => $data['role'],
            'enable' => true,
            'phone' => $data['phone'] ?? null,
        ]);
        return response()->json([
            'message' => 'Usuario registrado correctamente',
            'user' => $user,
        ], 201);
    }

}
