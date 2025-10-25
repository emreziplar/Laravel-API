<?php

namespace App\Http\Requests\Role\RolePermission;

use App\Traits\HttpRequestRules\RolePermissionRules;
use Illuminate\Foundation\Http\FormRequest;

class AssignPermissionRequest extends FormRequest
{
    use RolePermissionRules;

    public function rules(): array
    {
        return $this->assignRoleRequestRules();
    }
}
