<?php

namespace App\Http\Requests\Role\Permission;

use App\Traits\HttpRequestRules\PermissionRules;
use Illuminate\Foundation\Http\FormRequest;

class CreatePermissionRequest extends FormRequest
{
    use PermissionRules;

    public function rules(): array
    {
        return $this->createPermissionRequestRules();
    }
}
