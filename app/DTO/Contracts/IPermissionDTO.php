<?php

namespace App\DTO\Contracts;

use App\Models\Permission;
use Illuminate\Support\Collection;

interface IPermissionDTO extends IDTO
{
    public function getPermission(): Permission|Collection|null;
}
