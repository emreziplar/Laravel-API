<?php

namespace App\Models\Contracts;

interface IRoleModel extends IBaseModel
{
    public function permissions();
}
