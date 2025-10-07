<?php

namespace App\Providers;

use App\Contracts\Auth\IAuthService;
use App\Services\Auth\AuthService;
use App\Services\Auth\SystemLoginService;
use Illuminate\Support\ServiceProvider;

class ServiceServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $loginServices = [
            SystemLoginService::class
        ];
        $this->app->tag($loginServices, 'login.services');
        $this->app->singleton(IAuthService::class, function ($app) {
            return new AuthService($app->tagged('login.services'));
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
