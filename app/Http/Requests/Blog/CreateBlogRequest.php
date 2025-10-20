<?php

namespace App\Http\Requests\Blog;

use App\Rules\HasLangCodeRule;
use Illuminate\Foundation\Http\FormRequest;

class CreateBlogRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'category_id' => 'required|int',
            'status' => 'nullable|int',
            'translations' => ['required', 'array', new HasLangCodeRule('en')],
            'translations.*.title' => 'required|string|max:125',
            'translations.*.slug' => 'nullable|alpha_dash',
            'translations.*.content' => 'required|string',
            'translations.*.lang_code' => 'required|string|max:5',
        ];
    }
}
