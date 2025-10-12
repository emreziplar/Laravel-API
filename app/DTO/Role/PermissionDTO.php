<?php

namespace App\DTO\Role;

use App\DTO\Contracts\IPermissionDTO;
use App\Models\Contracts\IPermissionModel;
use Illuminate\Support\Collection;

final class PermissionDTO implements IPermissionDTO
{
    private readonly IPermissionModel|Collection|null $permissionData;
    private readonly string $message;

    public function __construct(IPermissionModel|Collection|null $permissionData, string $message = '')
    {
        $this->permissionData = $permissionData;
        $this->message = $message;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getPermission(): IPermissionModel|Collection|null
    {
        return $this->permissionData;
    }
}
