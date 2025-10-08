<?php

namespace App\DTO\Role;

use App\DTO\BaseDTO;
use App\DTO\Contracts\IPermissionDTO;
use App\Http\Resources\Role\PermissionResource;
use App\Models\Permission;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Collection;

final class PermissionDTO implements IPermissionDTO
{
    private readonly Permission|Collection|null $permissionData;
    private readonly string $message;

    public function __construct(Permission|Collection|null $permissionData, string $message = '')
    {
        $this->permissionData = $permissionData;
        $this->message = $message;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getPermission(): Permission|Collection|null
    {
        return $this->permissionData;
    }
}
