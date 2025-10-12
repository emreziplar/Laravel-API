<?php

namespace App\Providers;

use App\Contracts\Auth\IAuthService;
use App\Contracts\Role\IPermissionService;
use App\Contracts\Role\IRoleService;
use App\Services\Auth\AuthService;
use App\Services\Auth\SystemLoginService;
use App\Services\Role\PermissionService;
use App\Services\Role\RoleService;
use Illuminate\Support\ServiceProvider;

class BusinessServiceProvider extends ServiceProvider
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
        $this->app->singleton(IRoleService::class, RoleService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
