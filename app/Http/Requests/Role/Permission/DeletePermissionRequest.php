<?php

namespace App\Http\Requests\Role\Permission;

use Illuminate\Foundation\Http\FormRequest;

class DeletePermissionRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'id' => 'required|integer',
        ];
    }
}
