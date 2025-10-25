<?php

namespace App\Http\Requests\Category;

use App\Traits\HttpRequestRules\CategoryRules;
use Illuminate\Foundation\Http\FormRequest;

class DeleteCategoryRequest extends FormRequest
{
    use CategoryRules;

    public function rules(): array
    {
        return $this->deleteCategoryRequestRules();
    }
}
