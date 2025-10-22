<?php

namespace App\DTO\Request\Category;

use App\Models\Contracts\ICategoryModel;

class UpdateCategoryDTO
{
    /**
     * @param ICategoryModel $category
     * @param int|null $parentId
     * @param int|null $status
     * @param array $translations
     */
    public function __construct(
        public readonly ICategoryModel $category,
        public readonly ?int           $parentId,
        public readonly ?int           $status,
        public readonly array          $translations
    )
    {
    }
}
