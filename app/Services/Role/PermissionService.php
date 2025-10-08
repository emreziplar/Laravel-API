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

    public function createPermission(array $data): IPermissionDTO
    {
        $permission = $this->permissionRepository->createPermission($data);

        if (!$permission)
            return new PermissionDTO(null, 'Permission is not created!');

        return new PermissionDTO($permission, 'Permission is successfully created!');
    }

    public function getPermission(array $filters): IPermissionDTO
    {
        $id = $filters['id'] ?? null;
        $name = $filters['name'] ?? null;
        $ability = $filters['ability'] ?? null;

        if ($id) {
            $permission = $this->permissionRepository->getPermission($id);
        } elseif ($name && $ability) {
            $permission = $this->permissionRepository->getPermission($name . '.' . $ability, 'name');
        } elseif ($name) {
            $permission = $this->permissionRepository->getPermissionByPrefixOrSuffix($name);
        } elseif ($ability) {
            $permission = $this->permissionRepository->getPermissionByPrefixOrSuffix(null, $ability);
        } else {
            $permission = $this->permissionRepository->all();
        }

        if ($permission instanceof Collection) {
            $found = $permission->isNotEmpty();
        } else {
            $found = $permission !== null;
        }

        $message = $found ? 'Permission(s) found!' : 'Permission not found!';

        return new PermissionDTO($found ? $permission : null, $message);
    }

    public function updatePermission(int $id, string $name): IPermissionDTO
    {
        $permission = $this->permissionRepository->updatePermission($id, $name);

        return new PermissionDTO($permission ? $permission : null, $permission ? 'Permission updated!' : 'Permission is not updated!');
    }

    public function deletePermission(int $id): IPermissionDTO
    {
        $permission_deleted = $this->permissionRepository->deletePermission($id);

        $permissionData = $permission_deleted ? collect() : null;

        return new PermissionDTO($permissionData, $permission_deleted ? 'Permission is successfully deleted!' : 'Permission is not deleted!');
    }
}
