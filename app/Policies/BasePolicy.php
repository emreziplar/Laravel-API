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

    protected function hasPermission(IUserModel $user,string $permission_name): bool
    {
        $role_id = $user->roleId() ?? null;
        if(!$role_id)
            return false;

        return $this->roleRepository->isPermissionOfRole($role_id,$permission_name);
    }
}
