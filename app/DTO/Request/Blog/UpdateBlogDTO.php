<?php

namespace App\DTO\Request\Blog;

use App\Models\Contracts\IBlogModel;
use App\Models\Contracts\IUserModel;

class UpdateBlogDTO
{
    /**
     * @param IBlogModel $blog
     * @param int|null $categoryId
     * @param int|null $status
     * @param IUserModel $user
     * @param array|null $translations
     */
    public function __construct(
        public readonly IBlogModel $blog,
        public readonly ?int        $categoryId,
        public readonly ?int       $status,
        public readonly IUserModel $user,
        public readonly ?array      $translations
    )
    {
    }
}
