<?php

namespace App\Http\Requests\Category;

use App\Traits\HttpRequestRules\CategoryRules;
use Illuminate\Foundation\Http\FormRequest;

class GetCategoryRequest extends FormRequest
{
    use CategoryRules;

    public function rules(): array
    {
        return $this->getCategoryRequestRules();
    }
}
