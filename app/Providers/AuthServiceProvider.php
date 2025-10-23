<?php

namespace App\Providers;


use App\Policies\Blog\BlogPolicy;
use App\Policies\Category\CategoryPolicy;
use App\Policies\Media\MediaPolicy;
use App\Policies\Role\PermissionPolicy;
use App\Policies\Role\RolePolicy;
use App\Policies\User\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    //db-agnostic
    protected $policies = [
        'permissionPolicy' => PermissionPolicy::class,
        'rolePolicy' => RolePolicy::class,
        'userPolicy' => UserPolicy::class,
        'categoryPolicy' => CategoryPolicy::class,
        'blogPolicy' => BlogPolicy::class,
        'mediaPolicy' => MediaPolicy::class,
    ];

    public function register(): void
    {

    }

    public function boot(): void
    {
        $this->registerPolicies();
    }
}
