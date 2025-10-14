<?php

namespace App\Policies\Role;

use App\Models\Contracts\IUserModel;
use App\Policies\BasePolicy;

class RolePolicy extends BasePolicy
{
    public function get(IUserModel $user)
    {
        return $this->hasPermission($user,'role.get');
    }

    public function create(IUserModel $user)
    {
        return $this->hasPermission($user,'role.create');
    }

    public function update(IUserModel $user)
    {
        return $this->hasPermission($user,'role.update');
    }

    public function delete(IUserModel $user)
    {
        return $this->hasPermission($user,'role.delete');
    }

    public function assignPermission(IUserModel $user)
    {
        return $this->hasPermission($user,'role.assignPermission');
    }

    public function revokePermission(IUserModel $user)
    {
        return $this->hasPermission($user,'role.revokePermission');
    }
}
