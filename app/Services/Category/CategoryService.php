<?php

namespace App\Services\Category;

use App\Contracts\Category\ICategoryService;
use App\DTO\Request\Category\CreateCategoryDTO;
use App\DTO\Request\Category\UpdateCategoryDTO;
use App\DTO\Response\ModelResponseDTO;
use App\Repositories\Contracts\Category\ICategoryRepository;

class CategoryService implements ICategoryService
{
    protected ICategoryRepository $categoryRepository;

    public function __construct(ICategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function create(array $data): ModelResponseDTO
    {
        $parent_id = $data['parent_id'] ?? null;
        if ($parent_id && !$parent = $this->categoryRepository->getFirst($parent_id))
            return new ModelResponseDTO(null, __t('category.parent_not_found'), 404);

        $createCategoryDTO = new CreateCategoryDTO(
            parentId: $parent_id,
            status: $data['status'] ?? null,
            translations: $data['translations']
        );

        $category = $this->categoryRepository->createWithTranslations($createCategoryDTO);
        if (!$category)
            return new ModelResponseDTO(null, __t('category.not_created'), 500);

        return new ModelResponseDTO($category, __t('category.created'), 201);
    }

    public function get(array $fields): ModelResponseDTO
    {
        $categories = $this->categoryRepository->getWithConditions($fields);

        if ($categories->isEmpty())
            return new ModelResponseDTO(null, __t('category.not_found'), 404);

        return new ModelResponseDTO($categories, __t('category.found'));
    }

    public function update(int $id, array $data): ModelResponseDTO
    {
        $category = $this->categoryRepository->getFirst($id);
        if (!$category)
            return new ModelResponseDTO(null, __t('category.not_found'), 404);

        $parent_id = $data['parent_id'] ?? null;

        if ($parent_id) {
            if (!$parent = $this->categoryRepository->getFirst($parent_id))
                return new ModelResponseDTO(null, __t('category.parent_not_found'), 404);

            if ($id === $parent->getId())
                return new ModelResponseDTO(null, __t('category.not_updated_as_parent'), 422);
        }

        $updateCategoryDTO = new UpdateCategoryDTO(
            category: $category,
            parentId: $parent_id,
            status: $data['status'] ?? null,
            translations: $data['translations'] ?? null
        );

        $category = $this->categoryRepository->updateWithTranslations($updateCategoryDTO);
        if (!$category)
            return new ModelResponseDTO(null, __t('category.not_updated'), 500);

        return new ModelResponseDTO($category, __t('category.updated'));
    }

    public function delete(int $id): ModelResponseDTO
    {
        $category = $this->categoryRepository->getFirst($id);
        if (!$category)
            return new ModelResponseDTO(null, __t('category.not_found'), 404);

        $category_deleted = $this->categoryRepository->delete($category);

        return new ModelResponseDTO(
            null,
            $category_deleted ? __t('category.deleted') : __t('category.not_deleted'),
            $category_deleted ? 200 : 500
        );
    }
}
