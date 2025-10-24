<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class NotFieldAloneRule implements ValidationRule
{
    protected mixed $allData;
    protected mixed $fields;

    public function __construct(mixed $allData, array $fields = ['id'])
    {
        $this->allData = $allData;
        $this->fields = $fields;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $otherFields = array_diff(array_keys($this->allData), $this->fields);
        $msgFields = implode(', ' , $this->fields);
        if (empty($otherFields))
            $fail("At least one field other than {$msgFields} must be provided.");
    }
}
