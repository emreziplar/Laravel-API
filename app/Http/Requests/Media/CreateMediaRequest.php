<?php

namespace App\Http\Requests\Media;

use App\Rules\FileExtensionRule;
use App\Rules\HasResourceRule;
use Illuminate\Foundation\Http\FormRequest;

class CreateMediaRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'resource_name' => ['required','string', new HasResourceRule()],
            'resource_id' => 'required|int',
            'files' => 'required|array|min:1|max:10',
            'files.*' => ['file', 'max:10240', new FileExtensionRule()]
        ];
    }
}
