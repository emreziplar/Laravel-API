<?php

namespace App\Contracts\Role;

use App\Contracts\IBaseService;
use App\DTO\Response\BaseResponseDTO;

interface IRoleService extends IBaseService
{
    public function assignPermission(array $data): BaseResponseDTO;
}
