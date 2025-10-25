<?php

namespace App\Http\Requests\Media;

use App\Rules\FileExtensionRule;
use App\Rules\HasResourceRule;
use App\Traits\HttpRequestRules\MediaRules;
use Illuminate\Foundation\Http\FormRequest;

class CreateMediaRequest extends FormRequest
{
    use MediaRules;

    public function rules(): array
    {
        return $this->createMediaRequestRules();
    }
}
