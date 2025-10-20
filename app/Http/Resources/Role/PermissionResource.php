<?php

namespace App\Http\Resources\Role;

use App\Models\Contracts\IPermissionModel;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin IPermissionModel
 */
class PermissionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->getId(),
            'name' => $this->name,
            'roles' => $this->roles?->pluck('role')
        ];
    }
}
