<?php

namespace App\Http\Requests\Role;

use Illuminate\Foundation\Http\FormRequest;

class GetRoleRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'id' => 'nullable|integer',
            'role' => 'nullable|string',
            'permissions' => 'nullable|bool'
        ];
    }
}
