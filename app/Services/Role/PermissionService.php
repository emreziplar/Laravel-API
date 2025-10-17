<?php

namespace App\Services\Role;

use App\Contracts\Role\IPermissionService;
use App\DTO\Contracts\IPermissionDTO;
use App\DTO\Role\PermissionDTO;
use App\Repositories\Contracts\Role\IPermissionRepository;
use Illuminate\Support\Collection;

class PermissionService implements IPermissionService
{
    protected IPermissionRepository $permissionRepository;

    public function __construct(IPermissionRepository $permissionRepository)
    {
        $this->permissionRepository = $permissionRepository;
    }

    public function create(array $data): IPermissionDTO
    {
        $permission = $this->permissionRepository->getByName($data['name']);
        if ($permission)
            return new PermissionDTO(null,  __t('permission.exists'));

        $permission = $this->permissionRepository->create($data);
        if (!$permission)
            return new PermissionDTO(null, __t('permission.not_created'));

        return new PermissionDTO($permission, __t('permission.created'));
    }

    public function get(array $fields): IPermissionDTO
    {
        $permission = $this->permissionRepository->getWithConditions($fields);

        $found = false;
        if ($permission->isNotEmpty())
            $found = true;

        return new PermissionDTO($found ? $permission : null, $found ? __t('permission.found') : __t('permission.not_found'));
    }

    public function update(int $id, array $data): IPermissionDTO
    {
        $permission = $this->permissionRepository->getFirst($id);
        if (!$permission)
            return new PermissionDTO(null, __t('permission.not_found'));

        if ($this->permissionRepository->isUpToDate($permission, $data))
            return new PermissionDTO(null, __t('permission.up_to_date'));

        $permission = $this->permissionRepository->update($permission, $data);
        return new PermissionDTO($permission ?? null, $permission ? __t('permission.updated') : __t('permission.not_updated'));
    }

    public function delete(int $id): IPermissionDTO
    {
        $permission = $this->permissionRepository->getFirst($id);
        if (!$permission)
            return new PermissionDTO(null, __t('permission.not_found'));

        $permission_deleted = $this->permissionRepository->delete($permission);

        $permissionData = $permission_deleted ? collect() : null;

        return new PermissionDTO($permissionData, $permission_deleted ? __t('permission.deleted') : __t('permission.not_deleted'));
    }
}
