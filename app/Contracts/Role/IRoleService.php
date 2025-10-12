<?php

namespace App\Contracts\Role;

use App\Contracts\IBaseService;
use App\DTO\Contracts\IRoleDTO;

/**
 * @extends IBaseService<IRoleDTO>
 */
interface IRoleService extends IBaseService
{
    public function assignPermission(array $data): IRoleDTO;
}
