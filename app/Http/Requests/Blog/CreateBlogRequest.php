<?php

namespace App\Http\Requests\Blog;

use App\Rules\HasLangCodeRule;
use App\Traits\HttpRequestRules\BlogRules;
use Illuminate\Foundation\Http\FormRequest;

class CreateBlogRequest extends FormRequest
{
    use BlogRules;

    public function rules(): array
    {
        return $this->createRequestBlogRules();
    }
}
