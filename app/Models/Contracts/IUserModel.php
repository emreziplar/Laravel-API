<?php

namespace App\Models\Contracts;

interface IUserModel extends IBaseModel
{
    public function role();

    public function roleId(): int;
}
