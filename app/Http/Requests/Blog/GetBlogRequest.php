<?php

namespace App\Http\Requests\Blog;

use App\Traits\HttpRequestRules\BlogRules;
use Illuminate\Foundation\Http\FormRequest;

class GetBlogRequest extends FormRequest
{
    use BlogRules;

    public function rules(): array
    {
        return $this->getRequestBlogRules();
    }
}
