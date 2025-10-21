<?php

namespace App\Contracts\Blog;

use App\Contracts\IBaseService;
use App\DTO\Response\ModelResponseDTO;
use App\Models\Contracts\IUserModel;

interface IBlogService extends IBaseService
{
    public function create(array $data, IUserModel $user = null): ModelResponseDTO;
}
