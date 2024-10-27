<?php

namespace App\Http\Handlers;

use App\Http\RepositoryInterfaces\User\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Hash;

class LoginHandler
{
    public function __construct(
        protected UserRepositoryInterface $userRepository
    ) {
    }

    /**
     * @throws AuthenticationException
     */
    public function handle(string $email, string $password): User
    {
        $user = $this->userRepository->findByEmail($email);

        if ($user && Hash::check($password, $user->password)) {
            return $user;
        }

        throw new AuthenticationException('Invalid credentials');
    }
}
