<?php

namespace App\Providers;

use App\Contracts\Auth\IAuthService;
use App\Contracts\Role\IPermissionService;
use App\Services\Auth\AuthService;
use App\Services\Auth\SystemLoginService;
use App\Services\Role\PermissionService;
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
        $this->app->singleton(IPermissionService::class, PermissionService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
