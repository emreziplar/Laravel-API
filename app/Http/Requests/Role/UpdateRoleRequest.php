<?php

namespace App\Http\Requests\Role;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRoleRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'id' => 'required|integer',
            'role' => 'required|string'
        ];
    }
}
