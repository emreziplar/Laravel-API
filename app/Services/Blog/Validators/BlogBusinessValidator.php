<?php

namespace App\Services\Blog\Validators;

use App\Contracts\IBaseBusinessValidator;
use App\Models\Contracts\IUserModel;
use App\Repositories\Contracts\Blog\IBlogRepository;
use App\Repositories\Contracts\Category\ICategoryRepository;
use App\Support\Validation\ValidationResult;
use Illuminate\Support\Facades\Auth;

class BlogBusinessValidator implements IBaseBusinessValidator
{
    protected IBlogRepository $blogRepository;
    protected ICategoryRepository $categoryRepository;

    public function __construct(IBlogRepository $blogRepository, ICategoryRepository $categoryRepository)
    {
        $this->blogRepository = $blogRepository;
        $this->categoryRepository = $categoryRepository;
    }

    public function validateForCreate(array $data, ?IUserModel $user = null): ValidationResult
    {
        if (!$user)
            throw new \InvalidArgumentException('User is required for blog creation!');

        $category = $this->categoryRepository->getFirst($data['category_id']);
        if (!$category)
            return ValidationResult::fail(__t('blog.category_not_found'), 404);

        return ValidationResult::success([
            'category' => $category,
            'user' => $user
        ]);
    }

    public function validateForUpdate(int $id, array $data, ?IUserModel $user = null): ValidationResult
    {
        if (!$user)
            throw new \InvalidArgumentException('User is required for blog creation!');

        $categoryId = $data['category_id'] ?? null;
        if ($categoryId) {
            $category = $this->categoryRepository->getFirst($categoryId);
            if (!$category)
                return ValidationResult::fail(__t('blog.category_not_found'), 404);
        }

        $blog = $this->blogRepository->getFirst($id);
        if (!$blog)
            return ValidationResult::fail(__t('blog.not_found'), 404);

        return ValidationResult::success([
            'category' => $category ?? null,
            'blog' => $blog,
            'user' => $user
        ]);
    }

    public function validateForDelete(int $id, ?IUserModel $user = null): ValidationResult
    {
        $blog = $this->blogRepository->getFirst($id);
        if (!$blog)
            return ValidationResult::fail(__t('blog.not_found'), 404);

        return ValidationResult::success($blog);
    }
}
