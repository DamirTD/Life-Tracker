<?php

namespace App\Http\RepositoryInterfaces\User;

use App\Models\User;

interface UserRepositoryInterface
{
    public function save(User $user): void;
}
