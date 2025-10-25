<?php

namespace App\Http\Requests\Media;

use App\Rules\HasResourceRule;
use App\Rules\NotFieldAloneRule;
use App\Traits\HttpRequestRules\MediaRules;
use Illuminate\Foundation\Http\FormRequest;

class GetMediaRequest extends FormRequest
{
    use MediaRules;

    public function rules(): array
    {
        return $this->getMediaRequestRules($this->all());
    }
}
