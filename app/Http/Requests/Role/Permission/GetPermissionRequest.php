<?php

namespace App\Http\Requests\Role\Permission;

use Illuminate\Foundation\Http\FormRequest;

class GetPermissionRequest extends FormRequest
{
    public function all($keys = null)
    {
        return $this->query();
    }

    public function rules(): array
    {
        return [
            'id' => 'nullable|integer',
            'name' => 'nullable|string',
            'ability' => 'nullable|string'
        ];
    }
}
