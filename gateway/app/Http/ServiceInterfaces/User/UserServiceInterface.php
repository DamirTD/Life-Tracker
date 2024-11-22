<?php

namespace App\Http\ServiceInterfaces\User;

use App\Models\User;

interface UserServiceInterface
{
    public function createUser(array $data): User;
}
