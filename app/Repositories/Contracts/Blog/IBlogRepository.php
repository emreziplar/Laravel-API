<?php

namespace App\Repositories\Contracts\Blog;

use App\DTO\Request\Blog\CreateBlogDTO;
use App\Models\Contracts\IBlogModel;
use App\Repositories\Contracts\IBaseRepository;

interface IBlogRepository extends IBaseRepository
{
    public function createWithTranslations(CreateBlogDTO $createBlogDTO): ?IBlogModel;

}
