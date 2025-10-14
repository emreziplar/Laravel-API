<?php

namespace App\Models\Contracts;

interface IPermissionModel extends IBaseModel
{
    public function roles();
}
