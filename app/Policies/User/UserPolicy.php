<?php

namespace App\Policies\User;

use App\Models\Contracts\IUserModel;
use App\Policies\BasePolicy;

class UserPolicy extends BasePolicy
{
    public function get(IUserModel $user)
    {
        return $this->hasPermission($user,'user.get');
    }

    public function create(IUserModel $user)
    {
        return $this->hasPermission($user,'user.create');
    }

    public function update(IUserModel $user)
    {
        return $this->hasPermission($user,'user.update');
    }

    public function delete(IUserModel $user)
    {
        return $this->hasPermission($user,'user.delete');
    }
}
