<?php

namespace App\Providers;


use App\Policies\Role\PermissionPolicy;
use App\Policies\Role\RolePolicy;
use App\Policies\User\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    //some policies are db-agnostic
    protected $policies = [
        'permissionPolicy' => PermissionPolicy::class,
        'rolePolicy' => RolePolicy::class,
        'userPolicy' => UserPolicy::class
    ];

    public function register(): void
    {

    }

    public function boot(): void
    {
        $this->registerPolicies();
    }
}
