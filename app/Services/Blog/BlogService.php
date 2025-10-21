<?php

namespace App\Services\Blog;

use App\Contracts\Blog\IBlogService;
use App\DTO\Request\Blog\CreateBlogDTO;
use App\DTO\Request\Blog\CreateBlogTranslationDTO;
use App\DTO\Response\ModelResponseDTO;
use App\Models\Contracts\IUserModel;
use App\Repositories\Contracts\Blog\IBlogRepository;
use App\Repositories\Contracts\Category\ICategoryRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

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
        if(!$category)
            return new ModelResponseDTO(null, __t('blog.category_not_found'));

        $createBlogDTO = new CreateBlogDTO(
            categoryId: $data['category_id'],
            status: $data['status'] ?? null,
            user: $user,
            translations: $data['translations']
        );

        $blog = $this->blogRepository->createWithTranslations($createBlogDTO);
        if (!$blog)
            return new ModelResponseDTO(null, __t('blog.not_created'));

        return new ModelResponseDTO($blog, __t('blog.created'));
    }

    public function get(array $fields): ModelResponseDTO
    {
        // TODO: Implement get() method.
    }

    public function update(int $id, array $data): ModelResponseDTO
    {
        // TODO: Implement update() method.
    }

    public function delete(int $id): ModelResponseDTO
    {
        // TODO: Implement delete() method.
    }
}
