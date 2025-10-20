<?php

namespace App\Repositories\Contracts\Blog;

use App\Models\Contracts\IBlogModel;
use App\Models\Contracts\IUserModel;
use App\Repositories\Contracts\IBaseRepository;

interface IBlogRepository extends IBaseRepository
{
    public function createWithTranslations(array $blogData, array $translationsData, IUserModel $user): ?IBlogModel;

}
