<?php

namespace App\Http\ServiceInterfaces\User;

interface UserServiceInterface
{
    public function getByEmailAndPassword(string $email, string $password): mixed;
    public function createUser(array $data): void;
}
