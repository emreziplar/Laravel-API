<?php

namespace App\Traits\HttpRequestRules;

trait UserRules
{
    public function createUserRequestRules(): array
    {
        return [
            'role_id' => 'required|int',
            'name' => 'required|string',
            'email' => 'required|email',
            'status' => 'nullable|int',
            'password' => 'required'
        ];
    }

    public function deleteUserRequestRules(): array
    {
        return [
            'id' => 'required|int'
        ];
    }

    public function getUserRequestRules(): array
    {
        return [
            'id' => 'nullable|int',
            'role_id' => 'nullable|int',
            'email' => 'nullable|email',
            'status' => 'nullable|int'
        ];
    }

    public function updateUserRequestRules(): array
    {
        return [
            'id' => 'required|int',
            'role_id' => 'nullable|int',
            'name' => 'nullable|string',
            'email' => 'nullable|email',
            'status' => 'nullable|int',
            'password' => 'nullable'
        ];
    }
}
