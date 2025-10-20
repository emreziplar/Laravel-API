<?php

namespace App\Services\Blog;

use App\Contracts\Blog\IBlogService;
use App\DTO\Response\BaseResponseDTO;
use App\Models\Contracts\IUserModel;
use Illuminate\Support\Facades\Auth;

class BlogService implements IBlogService
{

    public function create(array $data, IUserModel $user = null): BaseResponseDTO
    {
        $user ??= Auth::user();
        if(!$user)
            throw new \InvalidArgumentException('User is required for blog creation!');


    }

    public function get(array $fields): BaseResponseDTO
    {
        // TODO: Implement get() method.
    }

    public function update(int $id, array $data): BaseResponseDTO
    {
        // TODO: Implement update() method.
    }

    public function delete(int $id): BaseResponseDTO
    {
        // TODO: Implement delete() method.
    }
}
