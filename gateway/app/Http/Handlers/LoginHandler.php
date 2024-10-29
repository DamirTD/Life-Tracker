<?php

namespace App\Http\Handlers;

use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Hash;

class LoginHandler
{
    /**
     * @throws AuthenticationException
     */
    public function handle(string $email, string $password): User
    {
        $user = User::where('email', $email)->first();

        if ($user && Hash::check($password, $user->password)) {
            return $user;
        }

        throw new AuthenticationException('Invalid credentials');
    }
}
