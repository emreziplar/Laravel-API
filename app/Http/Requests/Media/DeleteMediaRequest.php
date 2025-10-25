<?php

namespace App\Http\Requests\Media;

use App\Traits\HttpRequestRules\MediaRules;
use Illuminate\Foundation\Http\FormRequest;

class DeleteMediaRequest extends FormRequest
{
    use MediaRules;

    public function rules(): array
    {
        return $this->deleteMediaRequestRules();
    }
}
