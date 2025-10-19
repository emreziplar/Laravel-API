<?php

namespace App\Providers;

use App\Contracts\Auth\IAuthService;
use App\Contracts\Category\ICategoryService;
use App\Contracts\Role\IPermissionService;
use App\Contracts\Role\IRoleService;
use App\Contracts\User\IUserService;
use App\Repositories\Contracts\Auth\IAuthRepository;
use App\Repositories\Contracts\User\IUserRepository;
use App\Services\Auth\AuthService;
use App\Services\Auth\SystemLoginService;
use App\Services\Category\CategoryService;
use App\Services\Role\PermissionService;
use App\Services\Role\RoleService;
use App\Services\User\UserService;
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
            return new AuthService($app->tagged('login.services'), $app->make(IAuthRepository::class), $app->make(IUserRepository::class));
        });
        $this->app->singleton(IPermissionService::class, PermissionService::class);
        $this->app->singleton(IRoleService::class, RoleService::class);
        $this->app->singleton(IUserService::class, UserService::class);
        $this->app->singleton(ICategoryService::class, CategoryService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
