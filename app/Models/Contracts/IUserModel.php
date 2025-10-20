<?php

namespace App\Models\Contracts;

interface IUserModel extends IBaseModel
{
    public function roleId(): ?int;
}
