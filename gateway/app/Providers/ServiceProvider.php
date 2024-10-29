<?php

namespace App\Providers;

use App\Http\ServiceInterfaces\User\UserServiceInterface;
use App\Http\Services\User\UserService;
use Illuminate\Support\ServiceProvider as ServiceProviderContract;

class ServiceProvider extends ServiceProviderContract
{
    public function register(): void
    {
        $this->app->bind(UserServiceInterface::class, UserService::class);
    }

    public function boot(): void
    {
    }
}
