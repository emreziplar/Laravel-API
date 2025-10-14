<?php

namespace App\Policies\Role;

use App\Models\Contracts\IUserModel;
use App\Policies\BasePolicy;

class PermissionPolicy extends BasePolicy
{
    public function get(IUserModel $user)
    {
        return $this->hasPermission($user,'permission.get');
    }

    public function create(IUserModel $user)
    {
        return $this->hasPermission($user,'permission.create');
    }

    public function update(IUserModel $user)
    {
        return $this->hasPermission($user,'permission.update');
    }

    public function delete(IUserModel $user)
    {
        return $this->hasPermission($user,'permission.delete');
    }

}
