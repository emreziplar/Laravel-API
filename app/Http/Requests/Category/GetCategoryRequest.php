<?php

namespace App\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;

class GetCategoryRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'id' => 'nullable|int'
        ];
    }
}
