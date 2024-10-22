<?php

namespace App\Http\Controllers\Auth;

use App\Http\Common\Enums\HttpStatusCode;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function login(LoginRequest $request): JsonResponse
    {
        ['email' => $email, 'password' => $password] = $request->validated();

        $user = User::where('email', $email)->first();

        if (!$user || !Hash::check($password, $user->password)) {
            return response()->json(['message' => 'Неверные учетные данные'], HttpStatusCode::UNAUTHORIZED->value);
        }

        return response()->json([
            'message'      => 'Успешный вход',
        ], HttpStatusCode::OK->value);
    }
}
