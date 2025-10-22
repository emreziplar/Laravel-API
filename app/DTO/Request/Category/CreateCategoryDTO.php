<?php

namespace App\DTO\Request\Category;

class CreateCategoryDTO
{
    /**
     * @param int|null $parentId
     * @param int|null $status
     * @param array $translations
     */
    public function __construct(
        public readonly ?int  $parentId,
        public readonly ?int  $status,
        public readonly array $translations
    )
    {
    }
}
