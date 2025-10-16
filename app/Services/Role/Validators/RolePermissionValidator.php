<?php

namespace App\Services\Role\Validators;

use App\Models\Contracts\IRoleModel;
use App\Repositories\Contracts\Role\IPermissionRepository;
use App\Repositories\Contracts\Role\IRoleRepository;

class RolePermissionValidator
{
    private IRoleRepository $roleRepository;
    private IPermissionRepository $permissionRepository;

    /**
     * @param IRoleRepository $roleRepository
     * @param IPermissionRepository $permissionRepository
     */
    public function __construct(IRoleRepository $roleRepository, IPermissionRepository $permissionRepository)
    {
        $this->roleRepository = $roleRepository;
        $this->permissionRepository = $permissionRepository;
    }

    public function getMissingPermissions(array $permissions): array
    {
        $current = $this->permissionRepository->pluckByName($permissions)->toArray();
        return array_diff($permissions, $current);
    }

    public function getAlreadyAssignedPermissions(IRoleModel $roleModel, array $permissions): array
    {
        $existing = $this->roleRepository->getPermissionNamesOfRole($roleModel)->toArray();
        return array_intersect($permissions, $existing);
    }

    public function checkUnassignedPermissions(IRoleModel $roleModel, array $permissions): array
    {
        $assigned_permissions = $this->getAlreadyAssignedPermissions($roleModel, $permissions);
        return array_diff($permissions, $assigned_permissions);
    }


}
