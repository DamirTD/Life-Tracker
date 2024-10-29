<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Http\ServiceInterfaces\User\UserServiceInterface;
use Illuminate\Http\JsonResponse;

class RegisterController extends Controller
{
    public function __construct(
        protected UserServiceInterface $userService
    ) {
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        return $this->wrap($request, function ($validatedData) {
            $this->userService->createUser($validatedData);
        });
    }
}
