<?php

namespace App\Services\Category\Validators;

use App\Contracts\Category\ICategoryBusinessValidator;
use App\Models\Contracts\IUserModel;
use App\Repositories\Contracts\Category\ICategoryRepository;
use App\Support\Validation\ValidationResult;

class CategoryBusinessValidator implements ICategoryBusinessValidator
{
    protected ICategoryRepository $categoryRepository;

    public function __construct(ICategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function validateForCreate(array $data, ?IUserModel $user = null): ValidationResult
    {
        $parent_id = $data['parent_id'] ?? null;
        if ($parent_id && !$parent = $this->categoryRepository->getFirst($parent_id))
            return ValidationResult::fail(__t('category.parent_not_found'), 404);

        return ValidationResult::success([
            'parent' => $parent ?? null
        ]);
    }

    public function validateForUpdate(int $id, array $data, ?IUserModel $user = null): ValidationResult
    {
        $category = $this->categoryRepository->getFirst($id);
        if (!$category)
            return ValidationResult::fail(__t('category.not_found'), 404);

        $parent_id = $data['parent_id'] ?? null;

        if ($parent_id) {
            if (!$parent = $this->categoryRepository->getFirst($parent_id))
                return ValidationResult::fail(__t('category.parent_not_found'), 404);


            if ($id === $parent->getId())
                return ValidationResult::fail(__t('category.not_updated_as_parent'), 422);
        }

        return ValidationResult::success([
            'category' => $category,
            'parent' => $parent ?? null
        ]);
    }

    public function validateForDelete(int $id, ?IUserModel $user = null): ValidationResult
    {
        $category = $this->categoryRepository->getFirst($id);
        if (!$category)
            return ValidationResult::fail(__t('category.not_found'), 404);

        return ValidationResult::success([
            'category' => $category,
        ]);
    }
}
