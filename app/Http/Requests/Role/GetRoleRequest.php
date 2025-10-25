<?php

namespace App\Http\Requests\Role;

use App\Traits\HttpRequestRules\RoleRules;
use Illuminate\Foundation\Http\FormRequest;

class GetRoleRequest extends FormRequest
{
    use RoleRules;

    public function rules(): array
    {
        return $this->getRoleRequestRules();
    }
}
