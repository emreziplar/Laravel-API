<?php

namespace App\Providers;

use App\Repositories\Contracts\Auth\IAuthRepository;
use App\Repositories\Contracts\Blog\IBlogRepository;
use App\Repositories\Contracts\Category\ICategoryRepository;
use App\Repositories\Contracts\Media\IMediaRepository;
use App\Repositories\Contracts\Role\IPermissionRepository;
use App\Repositories\Contracts\Role\IRoleRepository;
use App\Repositories\Contracts\User\IUserRepository;
use App\Repositories\Eloquent\Auth\AuthRepository;
use App\Repositories\Eloquent\Blog\BlogRepository;
use App\Repositories\Eloquent\Category\CategoryRepository;
use App\Repositories\Eloquent\Media\MediaRepository;
use App\Repositories\Eloquent\Role\PermissionRepository;
use App\Repositories\Eloquent\Role\RoleRepository;
use App\Repositories\Eloquent\User\UserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $repositories = [
            IAuthRepository::class => AuthRepository::class,
            IPermissionRepository::class => PermissionRepository::class,
            IRoleRepository::class => RoleRepository::class,
            IUserRepository::class => UserRepository::class,
            ICategoryRepository::class => CategoryRepository::class,
            IBlogRepository::class => BlogRepository::class,
            IMediaRepository::class => MediaRepository::class,
        ];
        foreach ($repositories as $repoContract => $repoClass) {
            $this->app->singleton($repoContract, $repoClass);
        }
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
