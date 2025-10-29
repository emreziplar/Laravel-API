<?php

namespace App\Repositories\Cache;

use App\Contracts\Cache\ICacheService;
use App\Models\Contracts\IBaseModel;
use App\Repositories\Contracts\IBaseRepository;
use Illuminate\Support\Collection;

abstract class CacheBaseRepository implements IBaseRepository
{
    protected IBaseRepository $baseRepository;
    protected ICacheService $cacheService;

    /**
     * @param IBaseRepository $baseRepository
     * @param ICacheService $cacheService
     */
    public function __construct(IBaseRepository $baseRepository, ICacheService $cacheService)
    {
        $this->baseRepository = $baseRepository;
        $this->cacheService = $cacheService;
    }

    abstract function getCacheKeyPrefix(): string;

    abstract function getTTL(): ?int;

    protected function getCacheTag()
    {
        return $this->getCacheKeyPrefix() . 'tag';
    }

    protected function buildCacheKey(mixed $data)
    {
        return $this->getCacheKeyPrefix() . 'data:' . md5(json_encode($data));
    }

    protected function getCacheIfExists($cacheKey)
    {
        $cachedData = $this->cacheService->tags($this->getCacheTag())->get($cacheKey);

        if ($cachedData)
            return $cachedData;

        return false;
    }

    public function create(array $data): ?IBaseModel
    {
        $created = $this->baseRepository->create($data);

        if ($created)
            $this->cacheService->tags($this->getCacheTag())->flush();

        return $created;
    }

    public function getFirst(int|string $data, string $col = 'id'): ?IBaseModel
    {
        $cacheKey = $this->buildCacheKey($data . ":col:{$col}");

        if ($cachedData = $this->getCacheIfExists($cacheKey))
            return $cachedData;

        $repoData = $this->baseRepository->getFirst($data, $col);

        if (!$repoData)
            return $repoData;

        return $this->cacheService->tags($this->getCacheTag())->remember(
            $this->buildCacheKey($data),
            $this->getTTL(),
            function () use ($repoData) {
                return $repoData;
            }
        );
    }

    public function getWithConditions(array $fields = []): Collection
    {
        $cacheKey = $this->buildCacheKey($fields);

        if ($cachedData = $this->getCacheIfExists($cacheKey))
            return $cachedData;

        $repoData = $this->baseRepository->getWithConditions($fields);

        if ($repoData->isEmpty())
            return $repoData;

        return $this->cacheService->tags($this->getCacheTag())->remember($cacheKey, $this->getTTL(), function () use ($repoData) {
            return $repoData;
        });
    }

    public function all(): Collection
    {
        $cacheKey = $this->buildCacheKey('all');
        if ($cached = $this->getCacheIfExists($cacheKey))
            return $cached;

        $all = $this->baseRepository->all();
        if ($all->isEmpty())
            return $all;

        return $this->cacheService->tags($this->getCacheTag())->remember($cacheKey, $this->getTTL(), function () use ($all) {
            return $all;
        });
    }

    public function isUpToDate(IBaseModel $baseModel, array $data): bool
    {
        return $this->baseRepository->isUpToDate($baseModel, $data);
    }

    public function update(IBaseModel $baseModel, array $data): ?IBaseModel
    {
        $updated = $this->baseRepository->update($baseModel, $data);
        if ($updated)
            $this->cacheService->tags($this->getCacheTag())->flush();
        return $updated;
    }

    public function delete(IBaseModel $baseModel): bool
    {
        $deleted = $this->baseRepository->delete($baseModel);
        if ($deleted)
            $this->cacheService->tags($this->getCacheTag())->flush();
        return $deleted;
    }

    public function pluckByColumn(string $col, array $data, string $pluckValuesCol, string $pluckKeysCol = null): Collection
    {
        return $this->baseRepository->pluckByColumn($col, $data, $pluckValuesCol, $pluckKeysCol);
    }

    public function getModelClass(): string
    {
        return $this->baseRepository->getModelClass();
    }
}
