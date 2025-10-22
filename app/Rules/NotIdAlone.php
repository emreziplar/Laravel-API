<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class NotIdAlone implements ValidationRule
{
    protected mixed $allData;

    public function __construct(mixed $allData)
    {
        $this->allData = $allData;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $otherFields = array_diff(array_keys($this->allData), ['id']);
        if (empty($otherFields))
            $fail('At least one field other than ID must be provided.');
    }
}
