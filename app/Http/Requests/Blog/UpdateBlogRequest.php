<?php

namespace App\Http\Requests\Blog;

use App\Rules\NotIdAlone;
use Illuminate\Foundation\Http\FormRequest;

class UpdateBlogRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'id' => ['required', 'int', new NotIdAlone($this->all())],
            'category_id' => 'nullable|int',
            'status' => 'nullable|int',
            'translations' => 'nullable|array',
            'translations.*.title' => 'nullable|string|max:125',
            'translations.*.slug' => 'nullable|alpha_dash',
            'translations.*.content' => 'nullable|string',
            'translations.*.lang_code' => 'required|string|max:5',
        ];
    }
}
