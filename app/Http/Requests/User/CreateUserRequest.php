<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'role_id' => 'required|int',
            'name' => 'required|string',
            'email' => 'required|email',
            'status' => 'nullable|int',
            'password' => 'required'
        ];
    }
}
