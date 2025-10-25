<?php

namespace App\Traits\HttpRequestRules;

use App\Rules\FileExtensionRule;
use App\Rules\HasResourceRule;
use App\Rules\NotFieldAloneRule;

trait MediaRules
{
    public function createMediaRequestRules(): array
    {
        return [
            'resource_name' => ['required','string', new HasResourceRule()],
            'resource_id' => 'required|int',
            'files' => 'required|array|min:1|max:10',
            'files.*' => ['file', 'max:10240', new FileExtensionRule()]
        ];
    }

    public function deleteMediaRequestRules():array
    {
        return [
            'id' => 'required|int'
        ];
    }

    public function getMediaRequestRules($allRequestData = null): array
    {
        return [
            'resource_name' => ['nullable', 'string', new HasResourceRule()],
            'resource_id' => ['nullable', 'int', new NotFieldAloneRule($allRequestData, ['resource_id'])],
        ];
    }
}
