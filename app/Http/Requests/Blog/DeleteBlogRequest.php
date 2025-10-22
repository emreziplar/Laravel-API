<?php

namespace App\Http\Requests\Blog;

use Illuminate\Foundation\Http\FormRequest;

class DeleteBlogRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'id' => 'required|int'
        ];
    }
}
