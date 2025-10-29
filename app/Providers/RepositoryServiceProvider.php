<?php

namespace App\Providers;

use App\Contracts\Cache\ICacheService;
use App\Repositories\Cache\Blog\CacheBlogRepository;
use App\Repositories\Cache\Category\CacheCategoryRepository;
use App\Repositories\Cache\Role\CachePermissionRepository;
use App\Repositories\Cache\Role\CacheRoleRepository;
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
use App\Services\Cache\Drivers\FileCacheService;
use App\Services\Cache\Drivers\RedisCacheService;
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
            IPermissionRepository::class => function ($app) {
                return new CachePermissionRepository(
                    $app->make(PermissionRepository::class),
                    $app->make(RedisCacheService::class)
                );
            },
            IRoleRepository::class => function ($app) {
                return new CacheRoleRepository(
                    $app->make(RoleRepository::class),
                    $app->make(RedisCacheService::class)
                );
            },
            IUserRepository::class => UserRepository::class,
            ICategoryRepository::class => function ($app) {
                return new CacheCategoryRepository(
                    $app->make(CategoryRepository::class),
                    $app->make(FileCacheService::class)
                );
            },
            IBlogRepository::class => function ($app) {
                return new CacheBlogRepository(
                    $app->make(BlogRepository::class),
                    $app->make(RedisCacheService::class)
                );
            },
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
