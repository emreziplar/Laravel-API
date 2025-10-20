<?php

namespace App\Policies\Blog;

use App\Models\Contracts\IUserModel;
use App\Models\Eloquent\User;
use App\Policies\BasePolicy;

class BlogPolicy extends BasePolicy
{
    public function create(IUserModel $user)
    {
        return $this->hasPermission($user,'create');
    }

    public function get(IUserModel $user)
    {
        return $this->hasPermission($user,'get');
    }

    public function update(IUserModel $user)
    {
        return $this->hasPermission($user,'update');
    }

    public function delete(IUserModel $user)
    {
        return $this->hasPermission($user,'delete');
    }
}
