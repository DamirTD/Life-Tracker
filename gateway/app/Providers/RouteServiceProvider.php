<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    protected $namespace = 'App\Http\Controllers';

    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        $this->routes(function () {
            Route::middleware('api')
                ->namespace($this->namespace)
                ->group(base_path('routes/api.php'));
        });
    }
}
