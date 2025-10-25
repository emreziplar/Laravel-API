<?php

namespace App\Traits\HttpRequestRules;

use App\Rules\HasLangCodeRule;
use App\Rules\NotFieldAloneRule;

trait BlogRules
{
    public function createRequestBlogRules(): array
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

    public function getRequestBlogRules(): array
    {
        return [
            'id' => 'nullable|int'
        ];
    }

    public function deleteRequestBlogRules():array
    {
        return [
            'id' => 'required|int'
        ];
    }

    public function updateRequestBlogRules($allRequestData = null):array
    {
        return [
            'id' => ['required', 'int', new NotFieldAloneRule($allRequestData)],
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
