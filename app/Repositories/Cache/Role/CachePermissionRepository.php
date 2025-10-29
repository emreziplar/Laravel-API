<?php

namespace App\Repositories\Cache\Role;

use App\Contracts\Cache\ICacheService;
use App\Models\Contracts\IPermissionModel;
use App\Repositories\Cache\CacheBaseRepository;
use App\Repositories\Contracts\Role\IPermissionRepository;
use Illuminate\Support\Collection;

class CachePermissionRepository extends CacheBaseRepository implements IPermissionRepository
{
    protected IPermissionRepository $permissionRepository;

    /**
     * @param IPermissionRepository $permissionRepository
     * @param ICacheService $cacheService
     */
    public function __construct(IPermissionRepository $permissionRepository, ICacheService $cacheService)
    {
        parent::__construct($permissionRepository, $cacheService);
        $this->permissionRepository = $permissionRepository;
    }

    function getCacheKeyPrefix(): string
    {
        return 'permission:';
    }

    function getTTL(): ?int
    {
        return null;
    }

    public function getByName(string $name): ?IPermissionModel
    {
        $cacheKey = $this->buildCacheKey('permissionName:' . $name);
        if ($cached = $this->getCacheIfExists($cacheKey))
            return $cached;

        $permission = $this->permissionRepository->getByName($name);
        if (!$permission)
            return $permission;

        return $this->cacheService->tags($this->getCacheTag())->remember($cacheKey, $this->getTTL(), function () use ($permission) {
            return $permission;
        });
    }

    public function pluckByName(array $permission_names): Collection
    {
        $cacheKey = $this->buildCacheKey(['permissionNames' => $permission_names]);
        if ($cached = $this->getCacheIfExists($cacheKey))
            return $cached;

        $permissionNames = $this->permissionRepository->pluckByName($permission_names);
        if (!$permissionNames)
            return $permissionNames;

        return $this->cacheService->tags($this->getCacheTag())->remember($cacheKey, $this->getTTL(), function () use ($permissionNames) {
            return $permissionNames;
        });
    }

    public function getIdsByNames(array $permission_names): Collection
    {
        $cacheKey = $this->buildCacheKey(['permissionIds' => $permission_names]);
        if ($cached = $this->getCacheIfExists($cacheKey))
            return $cached;

        $permissionIds = $this->permissionRepository->getIdsByNames($permission_names);
        if (!$permissionIds)
            return $permissionIds;

        return $this->cacheService->tags($this->getCacheTag())->remember($cacheKey, $this->getTTL(), function () use ($permissionIds) {
            return $permissionIds;
        });
    }
}
