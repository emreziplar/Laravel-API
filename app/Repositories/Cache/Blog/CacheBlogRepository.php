<?php

namespace App\Repositories\Cache\Blog;

use App\Contracts\Cache\ICacheService;
use App\DTO\Request\Blog\CreateBlogDTO;
use App\DTO\Request\Blog\UpdateBlogDTO;
use App\Models\Contracts\IBlogModel;
use App\Repositories\Cache\CacheBaseRepository;
use App\Repositories\Contracts\Blog\IBlogRepository;


class CacheBlogRepository extends CacheBaseRepository implements IBlogRepository
{
    protected IBlogRepository $blogRepository;

    /**
     * @param IBlogRepository $blogRepository
     * @param ICacheService $cacheService
     */
    public function __construct(IBlogRepository $blogRepository, ICacheService $cacheService)
    {
        parent::__construct($blogRepository, $cacheService);
        $this->blogRepository = $blogRepository;
    }

    public function getCacheKeyPrefix(): string
    {
        return 'blog:';
    }

    public function createWithTranslations(CreateBlogDTO $createBlogDTO): ?IBlogModel
    {
        $blog = $this->blogRepository->createWithTranslations($createBlogDTO);

        if ($blog)
            $this->cacheService->tags($this->getCacheTag())->flush();

        return $blog;
    }

    public function updateWithTranslations(UpdateBlogDTO $updateBlogDTO): ?IBlogModel
    {
        $blog = $this->blogRepository->updateWithTranslations($updateBlogDTO);

        if ($blog)
            $this->cacheService->tags($this->getCacheTag())->flush();

        return $blog;
    }

    function getTTL(): ?int
    {
        return null;
    }
}
