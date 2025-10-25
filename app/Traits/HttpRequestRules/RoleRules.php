<?php

namespace App\Traits\HttpRequestRules;

trait RoleRules
{
    public function createRoleRequestRules(): array
    {
        return [
            'role' => 'required|string'
        ];
    }

    public function deleteRoleRequestRules(): array
    {
        return [
            'id' => 'required|integer',
        ];
    }

    public function getRoleRequestRules(): array
    {
        return [
            'id' => 'nullable|integer',
            'role' => 'nullable|string',
            'permissions' => 'nullable|bool'
        ];
    }

    public function updateRoleRequestRules(): array
    {
        return [
            'id' => 'required|integer',
            'role' => 'required|string'
        ];
    }
}
