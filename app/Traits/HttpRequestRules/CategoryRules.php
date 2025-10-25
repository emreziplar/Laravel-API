<?php

namespace App\Traits\HttpRequestRules;

use App\Rules\HasLangCodeRule;

trait CategoryRules
{
    public function createCategoryRequestRules(): array
    {
        return [
            'parent_id' => 'nullable|int',
            'status' => 'nullable|int',
            'translations' => ['required', 'array', new HasLangCodeRule(config('app.fallback_locale'))],
            'translations.*.name' => 'required|string',
            'translations.*.slug' => 'nullable|alpha_dash',
            'translations.*.lang_code' => 'required|string|max:5',
        ];
    }

    public function deleteCategoryRequestRules():array
    {
        return [
            'id' => 'required|int'
        ];
    }

    public function getCategoryRequestRules(): array
    {
        return [
            'id' => 'nullable|int'
        ];
    }

    public function updateCategoryRequestRules():array
    {
        return [
            'id' => 'required|int',
            'parent_id' => 'nullable|int',
            'status' => 'nullable|int',
            'translations' => 'nullable|array',
            'translations.*.name' => 'required|string',
            'translations.*.slug' => 'nullable|alpha_dash',
            'translations.*.lang_code' => 'required|string|max:5',
        ];
    }
}
