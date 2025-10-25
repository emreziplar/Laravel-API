<?php

namespace App\Http\Requests\Category;

use App\Traits\HttpRequestRules\CategoryRules;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
{
    use CategoryRules;

    public function rules(): array
    {
        return $this->updateCategoryRequestRules();
    }
}
