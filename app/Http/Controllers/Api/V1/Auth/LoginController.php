<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function login(Request $request)
    {

        // $request->validate([
        //     'email' => ['required', 'email', 'exists:users,email'],
        //     'password' => ['required', 'string', 'min:6'],
        // ]);

        try {
            $user = User::where('email', $request->input('email'))->first();
            // dd($user);
            if (!$user) {
                return response()->json(['message' => 'Credenciais inválidas'], 401);
            }

            if (!$user || !Hash::check($request->input('password'), $user->password)) {
                return response()->json(['message' => 'Credenciais inválidas'], 401);
            }

            // if (!$user->email_verified_at) {
            //     return response()->json(['message' => 'Sua conta não está ativada, por favor verifique seu e-mail.'], 403);
            // }

            $token = $user->createToken('access_token')->plainTextToken;

            return response()->json([
                'user' => $user,
                'access_token' => $token
            ], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function me(Request $request)
    {
        $user = $request->user();
        return response()->json([
            'user' => $user
        ]);
    }


    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json(['message' => 'Logout realizado com sucesso'], 200);
    }
}
