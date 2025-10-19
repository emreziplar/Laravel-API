<?php

namespace App\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'id' => 'required|int',
            'parent_id' => 'nullable|int',
            'status' => 'nullable|int',
            'translations' => 'nullable|array',
            'translations.*.name' => 'nullable|string',
            'translations.*.slug' => 'nullable|alpha_dash',
            'translations.*.lang_code' => 'required|string|max:5',
        ];
    }
}
