<?php

namespace App\Http\Requests\Blog;

use Illuminate\Foundation\Http\FormRequest;

class GetBlogRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'id' => 'nullable|int'
        ];
    }
}
