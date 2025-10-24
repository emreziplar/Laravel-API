<?php

namespace App\Rules;

use App\Enums\ResourceType;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class HasResourceRule implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if(!in_array($value,ResourceType::values()))
            $fail('Invalid resource name!');
    }
}
