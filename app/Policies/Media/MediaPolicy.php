<?php

namespace App\Policies\Media;

use App\Models\Contracts\IUserModel;
use App\Policies\BasePolicy;

class MediaPolicy extends BasePolicy
{
    public function get(IUserModel $user)
    {
        return $this->hasPermission($user,'media.get');
    }

    public function create(IUserModel $user)
    {
        return $this->hasPermission($user,'media.create');
    }

    public function update(IUserModel $user)
    {
        return $this->hasPermission($user,'media.update');
    }

    public function delete(IUserModel $user)
    {
        return $this->hasPermission($user,'media.delete');
    }
}
