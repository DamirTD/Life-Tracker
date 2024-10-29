<?php

namespace App\Http\Repository\User;

use App\Http\RepositoryInterfaces\User\UserRepositoryInterface;
use App\Models\User;

class UserRepository implements UserRepositoryInterface
{
    public function save(User $user): void
    {
        $user->save();
    }
}
