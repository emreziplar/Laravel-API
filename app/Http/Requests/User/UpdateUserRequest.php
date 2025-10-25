<?php

namespace App\Http\Requests\User;

use App\Traits\HttpRequestRules\UserRules;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    use UserRules;

    public function rules(): array
    {
        return $this->updateUserRequestRules();
    }
}
