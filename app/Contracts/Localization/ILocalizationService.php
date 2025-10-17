<?php

namespace App\Contracts\Localization;

interface ILocalizationService
{
    public function translate(string $text, string $destination_lang_code = 'en', string $source_lang_code = 'en'): ?string;
}
