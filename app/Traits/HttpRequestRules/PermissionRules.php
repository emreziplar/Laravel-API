<?php

namespace App\Traits\HttpRequestRules;

trait PermissionRules
{
    public function createPermissionRequestRules(): array
    {
        return [
            'name' => 'required|string'
        ];
    }

    public function deletePermissionRequestRules(): array
    {
        return [
            'id' => 'required|integer',
        ];
    }

    public function getPermissionRequestRules(): array
    {
        return [
            'id' => 'nullable|integer',
            'name' => 'nullable|string',
            'ability' => 'nullable|string'
        ];
    }

    public function updatePermissionRequestRules(): array
    {
        return [
            'id' => 'required|integer',
            'name' => 'required|string'
        ];
    }
}
