<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class GetUserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'id' => 'nullable|int',
            'role_id' => 'nullable|int',
            'email' => 'nullable|email',
            'status' => 'nullable|int'
        ];
    }
}
