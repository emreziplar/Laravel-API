<?php

namespace App\Http\Requests\Role\RolePermission;

use Illuminate\Foundation\Http\FormRequest;

class AssignPermissionRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'role_id' => 'required|int',
            'permissions' => 'required|array'
        ];
    }
}
