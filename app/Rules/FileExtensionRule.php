<?php

namespace App\Rules;

use App\Support\Media\Media;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class FileExtensionRule implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!$value instanceof \Illuminate\Http\UploadedFile) {
            $fail('Invalid file!');
            return;
        }

        $allowedExtensions = Media::getAllowedFileExtensions();

        if (!in_array($value->getClientOriginalExtension(), $allowedExtensions))
            $fail("The file extension {$value->getClientOriginalExtension()} is not allowed. Allowed extensions: " . implode(', ', $allowedExtensions));
    }
}
