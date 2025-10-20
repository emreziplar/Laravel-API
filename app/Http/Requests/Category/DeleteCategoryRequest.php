<?php

namespace App\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;

class DeleteCategoryRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'id' => 'required|int'
        ];
    }
}
