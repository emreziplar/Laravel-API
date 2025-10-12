<?php

namespace App\Providers;

use App\Repositories\Contracts\Auth\IAuthRepository;
use App\Repositories\Contracts\Role\IPermissionRepository;
use App\Repositories\Contracts\Role\IRoleRepository;
use App\Repositories\Eloquent\Auth\AuthRepository;
use App\Repositories\Eloquent\Role\PermissionRepository;
use App\Repositories\Eloquent\Role\RoleRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(IAuthRepository::class, AuthRepository::class);
        $this->app->singleton(IPermissionRepository::class, PermissionRepository::class);
        $this->app->singleton(IRoleRepository::class, RoleRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
