<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);

        $token = Auth::guard('api')->login($user);

        return $this->respondWithToken($token);
    }

     public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // 1. Verificar si el usuario existe realmente
        $user = User::where('email', $credentials['email'])->first();

        if (!$user) {
            //Log::error("LOGIN FAIL: Usuario no encontrado con email: " . $credentials['email']);
            return response()->json(['error' => 'Usuario no existe'], 404);
        }

        // 2. Verificar manualmente el hash de la contraseña
        // Esto nos dirá si es un problema de contraseña o de configuración del Guard
        $passwordMatch =\Illuminate\Support\Facades\Hash::check($credentials['password'], $user->password);

        // Log::info("LOGIN DEBUG", [
        //     'email_enviado' => $credentials['email'],
        //     'password_enviado' => $credentials['password'],
        //     'hash_en_bd' => $user->password,
        //     'match_manual' => $passwordMatch ? 'SI COINCIDEN' : 'NO COINCIDEN',
        //     'guard_config' => config('auth.guards.api') // Ver qué driver usa la api
        // ]);

        if (!$passwordMatch) {
            Log::error("LOGIN FAIL: La contraseña enviada no genera el hash almacenado.");
        }

        // 3. Intento oficial con el guard
        if (! $token = Auth::guard('api')->attempt($credentials)) {
            //Log::error("LOGIN FAIL: El guard 'api' retornó false, aunque las credenciales podrían ser válidas.");
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    public function me()
    {
        $user = auth()->user();

        // Cargamos los roles y permisos del usuario
        $roles = $user->getRoleNames();
        $permissions = $user->getAllPermissions()->pluck('name');

        return response()->json([
            'user' => $user,
            'roles' => $roles,
            'permissions' => $permissions,
        ]);
    }

    public function logout()
    {
        Auth::guard('api')->logout();
        return response()->json(['message' => 'Logged out']);
    }

    public function refresh()
    {
        return $this->respondWithToken(Auth::guard('api')->refresh());
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::guard('api')->factory()->getTTL() * 60
        ]);
    }
}
