<?php

namespace App\DTO\Request\Blog;

use App\Models\Contracts\IUserModel;

class CreateBlogDTO
{
    /**
     * @param int $categoryId
     * @param int|null $status
     * @param IUserModel $user
     * @param array $translations
     */
    public function __construct(
        public readonly int        $categoryId,
        public readonly ?int       $status,
        public readonly IUserModel $user,
        public readonly array      $translations
    )
    {
    }
}
