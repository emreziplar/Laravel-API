<?php

namespace App\Repositories\Cache\Category;

use App\Contracts\Cache\ICacheService;
use App\DTO\Request\Category\CreateCategoryDTO;
use App\DTO\Request\Category\UpdateCategoryDTO;
use App\Models\Contracts\ICategoryModel;
use App\Repositories\Cache\CacheBaseRepository;
use App\Repositories\Contracts\Category\ICategoryRepository;


class CacheCategoryRepository extends CacheBaseRepository implements ICategoryRepository
{
    protected ICategoryRepository $categoryRepository;

    /**
     * @param ICategoryRepository $categoryRepository
     * @param ICacheService $cacheService
     */
    public function __construct(ICategoryRepository $categoryRepository, ICacheService $cacheService)
    {
        parent::__construct($categoryRepository, $cacheService);
        $this->categoryRepository = $categoryRepository;
    }

    public function getCacheKeyPrefix(): string
    {
        return 'category:';
    }

    function getTTL(): ?int
    {
        return null;
    }

    public function createWithTranslations(CreateCategoryDTO $createCategoryDTO): ?ICategoryModel
    {
        $category = $this->categoryRepository->createWithTranslations($createCategoryDTO);

        if ($category)
            $this->cacheService->tags($this->getCacheTag())->flush();

        return $category;
    }

    public function updateWithTranslations(UpdateCategoryDTO $updateCategoryDTO): ?ICategoryModel
    {
        $category = $this->categoryRepository->updateWithTranslations($updateCategoryDTO);

        if ($category)
            $this->cacheService->tags($this->getCacheTag())->flush();

        return $category;
    }

    public function getFullPath(ICategoryModel $categoryModel): string
    {
        $cacheKey = $this->buildCacheKey('full_path_id:' . $categoryModel->getId());
        return $this->cacheService->rememberForever($cacheKey, function () use ($categoryModel) {
            return $this->categoryRepository->getFullPath($categoryModel);
        });
    }
}
