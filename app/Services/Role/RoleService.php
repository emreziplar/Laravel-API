<?php

namespace App\Services\Role;

use App\Contracts\Role\IRoleService;
use App\DTO\Contracts\IRoleDTO;
use App\DTO\Role\RoleDTO;
use App\Models\Eloquent\Role;
use App\Repositories\Contracts\Role\IPermissionRepository;
use App\Repositories\Contracts\Role\IRoleRepository;
use App\Services\Role\Validators\RolePermissionValidator;
use Illuminate\Support\Collection;

class RoleService implements IRoleService
{
    protected IRoleRepository $roleRepository;
    protected IPermissionRepository $permissionRepository;
    protected RolePermissionValidator $roleValidator;

    public function __construct(IRoleRepository $roleRepository, IPermissionRepository $permissionRepository, RolePermissionValidator $roleValidator)
    {
        $this->roleRepository = $roleRepository;
        $this->permissionRepository = $permissionRepository;
        $this->roleValidator = $roleValidator;
    }

    public function create(array $data): IRoleDTO
    {
        $role = $this->roleRepository->getByRoleName($data['role']);
        if ($role)
            return new RoleDTO(null, __('role.exists'));

        $role = $this->roleRepository->create($data);
        if (!$role)
            return new RoleDTO(null, __('role.not_created'));

        return new RoleDTO($role, __('role.created'));
    }

    public function get(array $fields): IRoleDTO
    {
        $role = $this->roleRepository->getWithConditions($fields);

        $found = false;
        if ($role->isNotEmpty())
            $found = true;

        return new RoleDTO($found ? $role : null, $found ? __('role.found') : __('role.not_found'));
    }

    public function update(int $id, array $data): IRoleDTO
    {
        $role = $this->roleRepository->getFirst($id);
        if (!$role)
            return new RoleDTO(null, __('role.not_found'));

        if ($this->roleRepository->isUpToDate($role, $data))
            return new RoleDTO(null, __('role.up_to_date'));

        $role = $this->roleRepository->update($role, $data);
        return new RoleDTO($role ?? null, $role ? __('role.updated') : __('role.not_updated'));
    }

    public function delete(int $id): IRoleDTO
    {
        $role = $this->roleRepository->getFirst($id);
        if (!$role)
            return new RoleDTO(null, __('role.not_found'));

        $role_deleted = $this->roleRepository->delete($role);

        $roleData = $role_deleted ? collect() : null;

        return new RoleDTO($roleData, $role_deleted ? __('role.deleted') : __('role.not_deleted'));
    }

    public function assignPermission(array $data): IRoleDTO
    {
        $role = $this->roleRepository->getFirst($data['role_id']);
        if (!$role)
            return new RoleDTO(null, __('role.not_found'));

        $missing_permissions = $this->roleValidator->getMissingPermissions($data['permissions']);
        if (!empty($missing_permissions))
            return new RoleDTO(null, __('role.create_first', ['missing_permissions' => implode(',', $missing_permissions)]));

        $assigned_permissions = $this->roleValidator->getAlreadyAssignedPermissions($role, $data['permissions']);
        if (!empty($assigned_permissions))
            return new RoleDTO(null, __('role.already_has_permissions', ['assigned_permissions' => implode(',', $assigned_permissions)]));

        $permissionIds = $this->permissionRepository->getIdsByNames($data['permissions'])->toArray();
        $result = $this->roleRepository->assignPermissions($role, $permissionIds);
        if ($result['processed_count'] < 1)
            return new RoleDTO(null, __('role.not_assigned'));

        return new RoleDTO($role, __('role.successfully_assigned', ['permissions' => implode(',', $data['permissions'])]));
    }

    public function revokePermission(array $data): IRoleDTO
    {
        $role = $this->roleRepository->getFirst($data['role_id']);
        if (!$role)
            return new RoleDTO(null, __('role.not_found'));

        if (!empty($unassigned_permissions = $this->roleValidator->checkUnassignedPermissions($role, $data['permissions'])))
            return new RoleDTO(null, __('role.has_not_permissions', ['unassigned_permissions' => implode(',', $unassigned_permissions)]));

        $permissionIds = $this->permissionRepository->getIdsByNames($data['permissions'])->toArray();
        $result = $this->roleRepository->revokePermissions($role, $permissionIds);
        if ($result['processed_count'] < 1)
            return new RoleDTO(null, __('role.not_revoked'));

        return new RoleDTO($role, __('role.successfully_revoked', ['permissions' => implode(',', $data['permissions'])]));
    }

}
