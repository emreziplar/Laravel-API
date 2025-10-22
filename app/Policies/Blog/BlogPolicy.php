<?php

namespace App\Policies\Blog;

use App\Models\Contracts\IUserModel;
use App\Policies\BasePolicy;

class BlogPolicy extends BasePolicy
{
    public function create(IUserModel $user)
    {
        return $this->hasPermission($user,'blog.create');
    }

    public function get(IUserModel $user)
    {
        return $this->hasPermission($user,'blog.get');
    }

    public function update(IUserModel $user)
    {
        return $this->hasPermission($user,'blog.update');
    }

    public function delete(IUserModel $user)
    {
        return $this->hasPermission($user,'blog.delete');
    }
}
