<?php

namespace App\Services\Blog;

use App\Contracts\Blog\IBlogService;
use App\DTO\Request\Blog\CreateBlogDTO;
use App\DTO\Request\Blog\UpdateBlogDTO;
use App\DTO\Response\ModelResponseDTO;
use App\Models\Contracts\IUserModel;
use App\Repositories\Contracts\Blog\IBlogRepository;
use App\Repositories\Contracts\Category\ICategoryRepository;
use Illuminate\Support\Facades\Auth;

class BlogService implements IBlogService
{
    protected IBlogRepository $blogRepository;
    protected ICategoryRepository $categoryRepository;

    public function __construct(IBlogRepository $blogRepository, ICategoryRepository $categoryRepository)
    {
        $this->blogRepository = $blogRepository;
        $this->categoryRepository = $categoryRepository;
    }

    public function create(array $data, IUserModel $user = null): ModelResponseDTO
    {
        $user ??= Auth::user();
        if (!$user)
            throw new \InvalidArgumentException('User is required for blog creation!');

        $category = $this->categoryRepository->getFirst($data['category_id']);
        if (!$category)
            return new ModelResponseDTO(null, __t('blog.category_not_found'), 404);

        $createBlogDTO = new CreateBlogDTO(
            categoryId: $data['category_id'],
            status: $data['status'] ?? null,
            user: $user,
            translations: $data['translations']
        );

        $blog = $this->blogRepository->createWithTranslations($createBlogDTO);
        if (!$blog)
            return new ModelResponseDTO(null, __t('blog.not_created'), 500);

        return new ModelResponseDTO($blog, __t('blog.created'));
    }

    public function get(array $fields): ModelResponseDTO
    {
        $blog = $this->blogRepository->getWithConditions($fields);

        if ($blog->isEmpty())
            return new ModelResponseDTO(null, __t('blog.not_found'), 404);

        return new ModelResponseDTO($blog, __t('blog.found'));
    }

    public function update(int $id, array $data, IUserModel $user = null): ModelResponseDTO
    {
        $user ??= Auth::user();
        if (!$user)
            throw new \InvalidArgumentException('User is required for blog creation!');

        $categoryId = $data['category_id'] ?? null;
        if ($categoryId) {
            $category = $this->categoryRepository->getFirst($categoryId);
            if (!$category)
                return new ModelResponseDTO(null, __t('blog.category_not_found'), 404);
        }

        $blog = $this->blogRepository->getFirst($data['id']);
        if (!$blog)
            return new ModelResponseDTO(null, __t('blog.not_found'), 404);

        $updateBlogDTO = new UpdateBlogDTO(
            blog: $blog,
            categoryId: $categoryId,
            status: $data['status'] ?? null,
            user: $user,
            translations: $data['translations'] ?? null
        );

        $blog = $this->blogRepository->updateWithTranslations($updateBlogDTO);
        if (!$blog)
            return new ModelResponseDTO(null, __t('blog.not_updated'), 500);

        return new ModelResponseDTO($blog, __t('blog.updated'));
    }

    public function delete(int $id): ModelResponseDTO
    {
        $blog = $this->blogRepository->getFirst($id);
        if (!$blog)
            return new ModelResponseDTO(null, __t('blog.not_found'), 404);

        $deleted = $this->blogRepository->delete($blog);

        return new ModelResponseDTO(
            null,
            $deleted ? __t('blog.deleted') : __t('blog.not_deleted'),
            $deleted ? 200 : 500
        );
    }
}
