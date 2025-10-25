<?php

namespace App\Traits\HttpRequestRules;

trait RolePermissionRules
{
    public function assignRoleRequestRules(): array
    {
        return [
            'role_id' => 'required|int',
            'permissions' => 'required|array'
        ];
    }

    public function revokeRoleRequestRules(): array
    {
        return [
            'role_id' => 'required|int',
            'permissions' => 'required|array'
        ];
    }
}
