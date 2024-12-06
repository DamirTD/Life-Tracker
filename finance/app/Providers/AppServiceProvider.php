<?php

namespace App\Providers;

use App\Http\ServiceInterfaces\TransactionAnalyzerServiceInterface;
use App\Http\ServiceInterfaces\TransactionServiceInterface;
use App\Http\Services\TransactionAnalyzerService;
use App\Http\Services\TransactionService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(TransactionServiceInterface::class, TransactionService::class);
        $this->app->bind(TransactionAnalyzerServiceInterface::class, TransactionAnalyzerService::class);

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
