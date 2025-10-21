<?php

namespace App\Services\Category;

use App\Contracts\Category\ICategoryService;
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
        if ($parent_id)
            if (!$parent = $this->categoryRepository->getFirst($parent_id))
                return new ModelResponseDTO(null, __t('category.parent_not_found'));

        $category = $this->categoryRepository->create($data);
        if (!$category)
            return new ModelResponseDTO(null, __t('category.not_created'));

        return new ModelResponseDTO($category, __t('category.created'));
    }

    public function get(array $fields): ModelResponseDTO
    {
        $categories = $this->categoryRepository->getWithConditions($fields);

        if ($categories->isEmpty())
            return new ModelResponseDTO(null, __t('category.not_found'));

        return new ModelResponseDTO($categories, __t('category.found'));
    }

    public function update(int $id, array $data): ModelResponseDTO
    {
        $category = $this->categoryRepository->getFirst($id);
        if (!$category)
            return new ModelResponseDTO(null, __t('category.not_found'));

        $parent_id = $data['parent_id'] ?? null;

        if ($parent_id) {
            if (!$parent = $this->categoryRepository->getFirst($parent_id))
                return new ModelResponseDTO(null, __t('category.parent_not_found'));

            if ($id === $parent->getId())
                return new ModelResponseDTO(null, __t('category.not_updated_as_parent'));
        }

        $category = $this->categoryRepository->update($category, $data);
        if (!$category)
            return new ModelResponseDTO(null, __t('category.not_updated'));

        return new ModelResponseDTO($category, __t('category.updated'));
    }

    public function delete(int $id): ModelResponseDTO
    {
        $category = $this->categoryRepository->getFirst($id);
        if (!$category)
            return new ModelResponseDTO(null, __t('category.not_found'));

        $category_deleted = $this->categoryRepository->delete($category);

        $category = $category_deleted ? collect() : null; //TODO: refactor all delete responses

        return new ModelResponseDTO($category, $category_deleted ? __t('category.deleted') : __t('category.not_deleted'));
    }
}
