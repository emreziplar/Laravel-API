<?php

if (!function_exists('__t')) {
    function __t(string $key, array $replace = []): string|array|null
    {
        /** @var \App\Services\Localization\LocalizationService $localization */
        $localization = app(\App\Services\Localization\LocalizationService::class);
        $translated_pure_text = $localization->translate($key, $replace);
        return __($key, $replace);
    }
}
