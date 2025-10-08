<?php

namespace App\Contracts\Role;

use App\DTO\Contracts\IPermissionDTO;

interface IPermissionService
{
    public function createPermission(array $data): IPermissionDTO;

    public function getPermission(array $filters): IPermissionDTO;

    public function updatePermission(int $id, string $name): IPermissionDTO;

    public function deletePermission(int $id): IPermissionDTO;


}
