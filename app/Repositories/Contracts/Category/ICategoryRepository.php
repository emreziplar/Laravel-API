<?php

namespace App\Repositories\Contracts\Category;

use App\DTO\Request\Category\CreateCategoryDTO;
use App\DTO\Request\Category\UpdateCategoryDTO;
use App\Models\Contracts\ICategoryModel;
use App\Repositories\Contracts\IBaseRepository;

/**
 * @extends IBaseRepository<ICategoryModel>
 */
interface ICategoryRepository extends IBaseRepository
{
    public function createWithTranslations(CreateCategoryDTO $createCategoryDTO): ?ICategoryModel;

    public function updateWithTranslations(UpdateCategoryDTO $updateCategoryDTO): ?ICategoryModel;

    public function getFullPath(ICategoryModel $categoryModel): string;
}
