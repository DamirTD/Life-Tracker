<?php

namespace App\Http\Controllers;

use App\Models\user;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function login(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'login'    => ['required', 'string', 'max:255'],
            'password' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ], 422);
        }

        $fieldType = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'name';

        $user = User::where($fieldType, $request->login)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Invalid login or password',
            ], 401);
        }

        // Аутентификация пользователя
        Auth::login($user);

        return response()->json([
            'status'  => 'success',
            'message' => 'Login successful',
            'user'    => $user,
        ]);
    }

    public function logout(Request $request): JsonResponse
    {
        Auth::logout();

        return response()->json([
            'status'  => 'success',
            'message' => 'Logout successful',
        ]);
    }
}
