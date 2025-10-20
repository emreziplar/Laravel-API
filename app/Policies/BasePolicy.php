<?php

namespace App\Policies;

use App\Models\Contracts\IUserModel;
use App\Repositories\Contracts\Role\IRoleRepository;
use Illuminate\Auth\Access\HandlesAuthorization;

class BasePolicy
{
    use HandlesAuthorization;

    protected IRoleRepository $roleRepository;

    public function __construct(IRoleRepository $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    protected function hasPermission(IUserModel $user, string $permission_name): bool
    {
        $role = $user->role ?? null;
        if (!$role)
            return false;

        return $this->roleRepository->isPermissionOfRole($role, $permission_name); //TODO: refactor
    }
}
