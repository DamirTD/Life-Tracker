<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Http\Handlers\LoginHandler;
use App\Http\Requests\LoginRequest;

class LoginController extends Controller
{
    public function __construct(
        protected LoginHandler $loginHandler
    ) {
    }

    public function login(LoginRequest $request): JsonResponse
    {
        return $this->wrap($request, function ($validatedData) {
            $this->loginHandler->handle($validatedData['email'], $validatedData['password']);
        });
    }
}
