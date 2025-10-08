<?php

namespace App\Providers;

use App\Repositories\Contracts\Auth\IAuthRepository;
use App\Repositories\Contracts\Role\IPermissionRepository;
use App\Repositories\Eloquent\Auth\AuthRepository;
use App\Repositories\Eloquent\Role\PermissionRepository;
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
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
