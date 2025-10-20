<?php

namespace App\Http\Resources\Role;

use App\Models\Contracts\IRoleModel;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin IRoleModel
 */
class RoleResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->getId(),
            'role' => $this->role,
            'permissions' => $this->permissions?->pluck('name')
        ];
    }
}
