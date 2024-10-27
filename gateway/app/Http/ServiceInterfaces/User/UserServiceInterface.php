<?php

namespace App\Http\ServiceInterfaces\User;

use App\Models\User;

interface UserServiceInterface
{
    public function getByEmailAndPassword(string $email, string $password): User|null;
    public function createUser(array $data): void;
}
