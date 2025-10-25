<?php

namespace App\Services\Role;

use App\Contracts\Role\IPermissionService;
use App\DTO\Response\ModelResponseDTO;
use App\Models\Contracts\IUserModel;
use App\Repositories\Contracts\Role\IPermissionRepository;

class PermissionService implements IPermissionService
{
    protected IPermissionRepository $permissionRepository;

    public function __construct(IPermissionRepository $permissionRepository)
    {
        $this->permissionRepository = $permissionRepository;
    }

    public function create(array $data, ?IUserModel $user = null): ModelResponseDTO
    {
        $permission = $this->permissionRepository->getByName($data['name']);
        if ($permission)
            return new ModelResponseDTO(null, __t('permission.exists'), 409);

        $permission = $this->permissionRepository->create($data);
        if (!$permission)
            return new ModelResponseDTO(null, __t('permission.not_created'), 500);

        return new ModelResponseDTO($permission, __t('permission.created'));
    }

    public function get(array $fields): ModelResponseDTO
    {
        $permission = $this->permissionRepository->getWithConditions($fields);

        $found = false;
        if ($permission->isNotEmpty())
            $found = true;

        return new ModelResponseDTO(
            $found ? $permission : null,
            $found ? __t('permission.found') : __t('permission.not_found'),
            $found ? 200 : 404
        );
    }

    public function update(int $id, array $data, ?IUserModel $user = null): ModelResponseDTO
    {
        $permission = $this->permissionRepository->getFirst($id);
        if (!$permission)
            return new ModelResponseDTO(null, __t('permission.not_found'), 404);

        if ($this->permissionRepository->isUpToDate($permission, $data))
            return new ModelResponseDTO(null, __t('permission.up_to_date'), 400);

        $permission = $this->permissionRepository->update($permission, $data);
        return new ModelResponseDTO(
            $permission ?? null,
            $permission ? __t('permission.updated') : __t('permission.not_updated'),
            $permission ? 200 : 500
        );
    }

    public function delete(int $id, ?IUserModel $user = null): ModelResponseDTO
    {
        $permission = $this->permissionRepository->getFirst($id);
        if (!$permission)
            return new ModelResponseDTO(null, __t('permission.not_found'), 404);

        $permission_deleted = $this->permissionRepository->delete($permission);

        return new ModelResponseDTO(
            null,
            $permission_deleted ? __t('permission.deleted') : __t('permission.not_deleted'),
            $permission_deleted ? 200 : 500
        );
    }
}
