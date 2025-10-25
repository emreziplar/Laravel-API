<?php

namespace App\Http\Requests\Blog;

use App\Rules\NotFieldAloneRule;
use App\Traits\HttpRequestRules\BlogRules;
use Illuminate\Foundation\Http\FormRequest;

class UpdateBlogRequest extends FormRequest
{
    use BlogRules;

    public function rules(): array
    {
        return $this->updateBlogRequestRules($this->all());
    }
}
