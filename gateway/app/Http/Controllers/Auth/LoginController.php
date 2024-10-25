<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\ServiceInterfaces\User\UserServiceInterface;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\LoginRequest;

class LoginController extends Controller
{
    public function __construct(
        protected UserServiceInterface $userService
    ) {
    }

    public function login(LoginRequest $request): JsonResponse
    {
        return $this->wrap($request, function ($validatedData) {
            $this->userService->getByEmailAndPassword($validatedData['email'], $validatedData['password']);
        });
    }
}
