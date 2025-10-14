<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    public function rules(): array
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
