<?php

namespace App\Repositories\Cache\Role;

use App\Contracts\Cache\ICacheService;
use App\Models\Contracts\IRoleModel;
use App\Repositories\Cache\CacheBaseRepository;
use App\Repositories\Contracts\Role\IRoleRepository;
use Illuminate\Support\Collection;

class CacheRoleRepository extends CacheBaseRepository implements IRoleRepository
{
    protected IRoleRepository $roleRepository;

    /**
     * @param IRoleRepository $roleRepository
     * @param ICacheService $cacheService
     */
    public function __construct(IRoleRepository $roleRepository, ICacheService $cacheService)
    {
        parent::__construct($roleRepository, $cacheService);
        $this->roleRepository = $roleRepository;
    }

    function getCacheKeyPrefix(): string
    {
        return 'role:';
    }

    function getTTL(): ?int
    {
        return null;
    }

    public function getByRoleName(string $role_name): ?IRoleModel
    {
        $cacheKey = $this->buildCacheKey('roleName:' . $role_name);
        if ($cached = $this->getCacheIfExists($cacheKey))
            return $cached;

        $role = $this->roleRepository->getByRoleName($role_name);
        if (!$role)
            return $role;

        return $this->cacheService->tags($this->getCacheTag())->remember($cacheKey, $this->getTTL(), function () use ($role) {
            return $role;
        });
    }

    public function getPermissionNamesOfRole(IRoleModel $roleModel): Collection
    {
        $cacheKey = $this->buildCacheKey('permissionNames:' . $roleModel->getId());
        if ($cached = $this->getCacheIfExists($cacheKey))
            return $cached;

        $permissionNames = $this->roleRepository->getPermissionNamesOfRole($roleModel);
        if ($permissionNames->isEmpty())
            return $permissionNames;

        return $this->cacheService->tags($this->getCacheTag())->remember($cacheKey, $this->getTTL(), function () use ($permissionNames) {
            return $permissionNames;
        });
    }

    public function isPermissionOfRole(IRoleModel $roleModel, string $permission_name): bool
    {
        $cacheKey = $this->buildCacheKey("hasPermission:{$permission_name}:role:{$roleModel->getId()}");
        if ($cached = $this->getCacheIfExists($cacheKey))
            return $cached;

        $isPermissionOfRole = $this->roleRepository->isPermissionOfRole($roleModel, $permission_name);
        if (!$isPermissionOfRole)
            return $isPermissionOfRole;

        return $this->cacheService->tags($this->getCacheTag())->remember($cacheKey, $this->getTTL(), function () use ($isPermissionOfRole) {
            return $isPermissionOfRole;
        });
    }

    public function assignPermissions(IRoleModel $roleModel, array $permissionIds): bool
    {
        $isAssigned = $this->roleRepository->assignPermissions($roleModel, $permissionIds);
        if ($isAssigned)
            $this->cacheService->tags($this->getCacheTag())->flush();
        return $isAssigned;
    }

    public function revokePermissions(IRoleModel $roleModel, array $permissionIds): bool
    {
        $isRevoked = $this->roleRepository->revokePermissions($roleModel, $permissionIds);
        if ($isRevoked)
            $this->cacheService->tags($this->getCacheTag())->flush();
        return $isRevoked;
    }
}
