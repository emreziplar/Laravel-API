<?php

namespace App\Http\Requests\Category;

use App\Rules\HasLangCodeRule;
use App\Traits\HttpRequestRules\CategoryRules;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class CreateCategoryRequest extends FormRequest
{
    use CategoryRules;

    public function rules(): array
    {
        return $this->createCategoryRequestRules();
    }

}
