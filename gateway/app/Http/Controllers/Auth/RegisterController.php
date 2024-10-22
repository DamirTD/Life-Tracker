<?php

namespace App\Http\Controllers\Auth;

use App\Http\Common\Enums\HttpStatusCode;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class RegisterController extends Controller
{
    public function register(RegisterRequest $request): JsonResponse
    {
        User::createUser($request->validated());

        return response()->json(['message' => 'Пользователь успешно создан'], HttpStatusCode::CREATED->value);
    }
}
