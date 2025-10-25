<?php

namespace App\Http\Requests\Role\RolePermission;

use App\Traits\HttpRequestRules\RolePermissionRules;
use Illuminate\Foundation\Http\FormRequest;

class RevokePermissionRequest extends FormRequest
{
    use RolePermissionRules;

    public function rules(): array
    {
        return $this->revokeRoleRequestRules();
    }
}
