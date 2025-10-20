<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class HasLangCodeRule implements ValidationRule
{
    protected string $lang_code;

    public function __construct($lang_code = 'en')
    {
        $this->lang_code = $lang_code;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $langCodes = is_array($value) ? array_column($value, 'lang_code') : [];
        if (!in_array($this->lang_code, $langCodes))
            $fail("The {$attribute} data must have at least one '{$this->lang_code}' lang code!");
    }
}
