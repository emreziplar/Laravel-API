<?php

namespace App\Models\Contracts;

interface IUserModel extends IBaseModel
{
    public function getRoleId(): ?int;
}
