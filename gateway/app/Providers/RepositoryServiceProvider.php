<?php

namespace App\Providers;

use App\Http\Repository\User\UserRepository;
use App\Http\RepositoryInterfaces\User\UserRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
    }

    public function boot(): void
    {
    }
}
