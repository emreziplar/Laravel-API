<?php

namespace App\Repositories\Contracts\Blog;

use App\DTO\Request\Blog\CreateBlogDTO;
use App\DTO\Request\Blog\UpdateBlogDTO;
use App\Models\Contracts\IBlogModel;
use App\Repositories\Contracts\IBaseRepository;

interface IBlogRepository extends IBaseRepository
{
    public function createWithTranslations(CreateBlogDTO $createBlogDTO): ?IBlogModel;

    public function updateWithTranslations(UpdateBlogDTO $updateBlogDTO): ?IBlogModel;

}
