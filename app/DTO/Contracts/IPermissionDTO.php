<?php

namespace App\DTO\Contracts;

use App\Models\Contracts\IPermissionModel;
use Illuminate\Support\Collection;

interface IPermissionDTO extends IDTO
{
    public function getPermission(): IPermissionModel|Collection|null;
}
