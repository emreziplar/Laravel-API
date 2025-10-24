<?php

namespace App\Http\Requests\Media;

use App\Rules\HasResourceRule;
use App\Rules\NotFieldAloneRule;
use Illuminate\Foundation\Http\FormRequest;

class GetMediaRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'resource_name' => ['nullable', 'string', new HasResourceRule()],
            'resource_id' => ['nullable', 'int', new NotFieldAloneRule($this->all(), ['resource_id'])],
        ];
    }
}
