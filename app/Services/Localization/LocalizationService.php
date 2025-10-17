<?php

namespace App\Services\Localization;

use App\Contracts\Localization\ILocalizationService;
use App\Support\Localization\Localization;
use Illuminate\Support\Facades\App;

class LocalizationService
{
    protected array $translator_services = [];

    public function __construct(array $translator_services)
    {
        $this->translator_services = $translator_services;
    }

    public function translate(string $key, array $replace = []): ?string
    {
        if (Localization::checkTranslationIfExists($key, $this->getDestinationLang())
            || !Localization::checkLangIfAvailable($this->getDestinationLang())
            || !$driver = $this->resolveDriver())
            return null;

        $pure_translation = (Localization::getDefaultPureTranslation($key));
        [$replaced_text, $safe_translation_keys] = $this->maskPlaceHolders($pure_translation, $replace);
        $translated_text = $driver->translate($replaced_text, $this->getDestinationLang());
        if (is_null($translated_text))
            return null;

        $translated_text = $this->unmaskPlaceHolders($translated_text, $safe_translation_keys);

        Localization::writeLangFile($key, $translated_text, $this->getDestinationLang());

        return $translated_text;
    }

    private function resolveDriver(): ?ILocalizationService
    {
        //Default driver is currently static.
        //It is possible to use 'localization.drivers' dynamically when needed.
        $default_driver = config('localization.default_driver') ?? '';
        if (empty($this->translator_services[$default_driver]))
            return null;

        return resolve($this->translator_services[$default_driver]);
    }

    private function maskPlaceHolders(string $pure_translation, array $replace = []): array
    {
        $safe_translation_keys = [];
        foreach ($replace as $key => $value) {
            $search_key = ":{$key}";
            $replace_key = "{" . uniqid() . "}";
            $pure_translation = str_replace($search_key, $replace_key, $pure_translation);
            $safe_translation_keys[$replace_key] = ":{$key}";
        }

        return [$pure_translation, $safe_translation_keys];
    }

    private function unmaskPlaceHolders(string $translated_text, $safe_translation_keys): ?string
    {
        foreach ($safe_translation_keys as $key => $value)
            $translated_text = str_replace($key, $value, $translated_text);

        return $translated_text;
    }

    private function getDestinationLang()
    {
        return App::getLocale();
    }

}
