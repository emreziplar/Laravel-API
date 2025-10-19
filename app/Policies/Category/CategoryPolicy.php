<?php

namespace App\Policies\Category;

use App\Models\Contracts\IUserModel;
use App\Models\Eloquent\User;
use App\Policies\BasePolicy;

class CategoryPolicy extends BasePolicy
{
    public function create(IUserModel $user)
    {
        return $this->hasPermission($user,'category.create');
    }

    public function get(IUserModel $user)
    {
        return $this->hasPermission($user,'category.get');
    }

    public function update(IUserModel $user)
    {
        return $this->hasPermission($user,'category.update');
    }
}
