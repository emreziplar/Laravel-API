<?php

namespace App\Contracts\Role;

use App\Contracts\IBaseService;
use App\DTO\Response\ModelResponseDTO;

interface IRoleService extends IBaseService
{
    public function assignPermission(array $data): ModelResponseDTO;
}
