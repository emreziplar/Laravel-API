<?php

namespace App\Providers;

use App\Contracts\Auth\IAuthService;
use App\Contracts\Blog\IBlogService;
use App\Contracts\Category\ICategoryService;
use App\Contracts\Media\IMediaHandler;
use App\Contracts\Media\IMediaService;
use App\Contracts\Role\IPermissionService;
use App\Contracts\Role\IRoleService;
use App\Contracts\User\IUserService;
use App\Repositories\Contracts\Auth\IAuthRepository;
use App\Repositories\Contracts\User\IUserRepository;
use App\Services\Auth\AuthService;
use App\Services\Auth\ApiLoginService;
use App\Services\Blog\BlogService;
use App\Services\Category\CategoryService;
use App\Services\Media\MediaHandlerProxy;
use App\Services\Media\MediaService;
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
            ApiLoginService::class
        ];
        $this->app->tag($loginServices, 'login.services');
        $this->app->singleton(IAuthService::class, function ($app) {
            return new AuthService($app->tagged('login.services'), $app->make(IAuthRepository::class), $app->make(IUserRepository::class));
        }); //TODO: edit

        $services = [
            IPermissionService::class => PermissionService::class,
            IRoleService::class => RoleService::class,
            IUserService::class => UserService::class,
            ICategoryService::class => CategoryService::class,
            IBlogService::class => BlogService::class,
            IMediaService::class => MediaService::class,
            IMediaHandler::class => MediaHandlerProxy::class,
        ];
        foreach ($services as $contract => $class)
            $this->app->singleton($contract, $class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
