<?php

namespace App\Services\Category;

use App\Contracts\Category\ICategoryService;
use App\DTO\Category\CategoryDTO;
use App\DTO\Contracts\ICategoryDTO;
use App\DTO\Contracts\IDTO;
use App\Repositories\Contracts\Category\ICategoryRepository;

class CategoryService implements ICategoryService
{
    protected ICategoryRepository $categoryRepository;

    public function __construct(ICategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function create(array $data): ICategoryDTO
    {
        $parent_id = $data['parent_id'] ?? null;
        if ($parent_id)
            if (!$parent = $this->categoryRepository->getFirst($parent_id))
                return new CategoryDTO(null, __t('category.parent_not_found'));

        $category = $this->categoryRepository->create($data);
        if (!$category)
            return new CategoryDTO(null, __t('category.not_created'));

        return new CategoryDTO($category, __t('category.created'));
    }

    public function get(array $fields): ICategoryDTO
    {
        $categories = $this->categoryRepository->getWithConditions($fields);



        if($categories->isEmpty())
            return new CategoryDTO(null,__t('category.not_found'));

        return new CategoryDTO($categories,__t('category.found'));
    }

    public function update(int $id, array $data): ICategoryDTO
    {
        // TODO: Implement update() method.
    }

    public function delete(int $id): ICategoryDTO
    {
        // TODO: Implement delete() method.
    }
}
