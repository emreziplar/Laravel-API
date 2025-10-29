<?php

namespace App\Services\Role;

use App\Contracts\Role\IRoleService;
use App\DTO\Response\ModelResponseDTO;
use App\Models\Contracts\IUserModel;
use App\Repositories\Contracts\Role\IPermissionRepository;
use App\Repositories\Contracts\Role\IRoleRepository;
use App\Services\Role\Validators\RolePermissionValidator;

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

    public function create(array $data, ?IUserModel $user = null): ModelResponseDTO
    {
        $role = $this->roleRepository->getByRoleName($data['role']);
        if ($role)
            return new ModelResponseDTO(null, __t('role.exists'), 409);

        $role = $this->roleRepository->create($data);
        if (!$role)
            return new ModelResponseDTO(null, __t('role.not_created'), 500);

        return new ModelResponseDTO($role, __t('role.created'));
    }

    public function get(array $fields): ModelResponseDTO
    {
        $role = $this->roleRepository->getWithConditions($fields);

        $found = false;
        if ($role->isNotEmpty())
            $found = true;

        return new ModelResponseDTO(
            $found ? $role : null,
            $found ? __t('role.found') : __t('role.not_found'),
            $found ? 200 : 404
        );
    }

    public function update(int $id, array $data, ?IUserModel $user = null): ModelResponseDTO
    {
        $role = $this->roleRepository->getFirst($id);
        if (!$role)
            return new ModelResponseDTO(null, __t('role.not_found'), 404);

        if ($this->roleRepository->isUpToDate($role, $data))
            return new ModelResponseDTO(null, __t('role.up_to_date'), 400);

        $role = $this->roleRepository->update($role, $data);
        return new ModelResponseDTO(
            $role ?? null,
            $role ? __t('role.updated') : __t('role.not_updated'),
            $role ? 200 : 500
        );
    }

    public function delete(int $id, ?IUserModel $user = null): ModelResponseDTO
    {
        $role = $this->roleRepository->getFirst($id);
        if (!$role)
            return new ModelResponseDTO(null, __t('role.not_found'), 404);

        $role_deleted = $this->roleRepository->delete($role);

        return new ModelResponseDTO(
            null,
            $role_deleted ? __t('role.deleted') : __t('role.not_deleted'),
            $role_deleted ? 200 : 500
        );
    }

    public function assignPermission(array $data): ModelResponseDTO
    {
        $role = $this->roleRepository->getFirst($data['role_id']);
        if (!$role)
            return new ModelResponseDTO(null, __t('role.not_found'), 404);

        $missing_permissions = $this->roleValidator->getMissingPermissions($data['permissions']);
        if (!empty($missing_permissions))
            return new ModelResponseDTO(null, __t('role.create_first', ['missing_permissions' => implode(',', $missing_permissions)]), 404);

        $assigned_permissions = $this->roleValidator->getAlreadyAssignedPermissions($role, $data['permissions']);
        if (!empty($assigned_permissions))
            return new ModelResponseDTO(null, __t('role.already_has_permissions', ['assigned_permissions' => implode(',', $assigned_permissions)]), 409);

        $permissionIds = $this->permissionRepository->getIdsByNames($data['permissions'])->toArray();
        $isAssigned = $this->roleRepository->assignPermissions($role, $permissionIds);
        if (!$isAssigned)
            return new ModelResponseDTO(null, __t('role.not_assigned'), 500);

        return new ModelResponseDTO($role, __t('role.successfully_assigned', ['permissions' => implode(',', $data['permissions'])]));
    }

    public function revokePermission(array $data): ModelResponseDTO
    {
        $role = $this->roleRepository->getFirst($data['role_id']);
        if (!$role)
            return new ModelResponseDTO(null, __t('role.not_found'), 404);

        if (!empty($unassigned_permissions = $this->roleValidator->checkUnassignedPermissions($role, $data['permissions'])))
            return new ModelResponseDTO(null, __t('role.has_not_permissions', ['unassigned_permissions' => implode(',', $unassigned_permissions)]), 404);

        $permissionIds = $this->permissionRepository->getIdsByNames($data['permissions'])->toArray();
        $isRevoked = $this->roleRepository->revokePermissions($role, $permissionIds);
        if (!$isRevoked)
            return new ModelResponseDTO(null, __t('role.not_revoked'), 500);

        return new ModelResponseDTO($role, __t('role.successfully_revoked', ['permissions' => implode(',', $data['permissions'])]));
    }

}
