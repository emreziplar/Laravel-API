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
            return new PermissionDTO(null, 'Permission is already exists!');

        $permission = $this->permissionRepository->create($data);
        if (!$permission)
            return new PermissionDTO(null, 'Permission is not created!');

        return new PermissionDTO($permission, 'Permission is successfully created!');
    }

    public function get(array $fields): IPermissionDTO
    {
        $permission = $this->permissionRepository->getWithConditions($fields);

        $found = false;
        if ($permission->isNotEmpty())
            $found = true;

        return new PermissionDTO($found ? $permission : null, $found ? 'Permission(s) found.' : 'Permission not found!');
    }

    public function update(int $id, array $data): IPermissionDTO
    {
        $permission = $this->permissionRepository->getFirst($id);
        if (!$permission)
            return new PermissionDTO(null, 'Permission not found!');

        if ($this->permissionRepository->isUpToDate($permission, $data))
            return new PermissionDTO(null, 'Already up-to-date!');

        $permission = $this->permissionRepository->update($permission, $data);
        return new PermissionDTO($permission ?? null, $permission ? 'Permission updated!' : 'Permission is not updated!');
    }

    public function delete(int $id): IPermissionDTO
    {
        $permission = $this->permissionRepository->getFirst($id);
        if (!$permission)
            return new PermissionDTO(null, 'Permission not found!');

        $permission_deleted = $this->permissionRepository->delete($permission);

        $permissionData = $permission_deleted ? collect() : null;

        return new PermissionDTO($permissionData, $permission_deleted ? 'Permission is successfully deleted!' : 'Permission is not deleted!');
    }
}
