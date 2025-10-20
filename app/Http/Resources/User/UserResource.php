<?php

namespace App\Http\Resources\User;

use App\Http\Resources\Role\RoleResource;
use App\Models\Contracts\IUserModel;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin IUserModel
 */
class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->getId(),
            'role_id' => $this->roleId(),
            'name' => $this->name,
            'email' => $this->email,
            'status' => $this->status,
            'role' => new RoleResource($this->role),
        ];
    }
}
