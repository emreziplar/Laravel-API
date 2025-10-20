<?php

namespace App\Http\Requests\Category;

use App\Rules\HasLangCodeRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class CreateCategoryRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'parent_id' => 'nullable|int',
            'status' => 'nullable|int',
            'translations' => ['required', 'array', new HasLangCodeRule(config('app.fallback_locale'))],
            'translations.*.name' => 'required|string',
            'translations.*.slug' => 'nullable|alpha_dash',
            'translations.*.lang_code' => 'required|string|max:5',
        ];
    }

}
