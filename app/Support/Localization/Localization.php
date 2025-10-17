<?php

namespace App\Support\Localization;

use Illuminate\Support\Arr;

class Localization
{
    public static function checkTranslationIfExists(string $key, string $lang_code = ''): bool
    {
        $lang_code = $lang_code === '' ? config('app.locale') : $lang_code;
        $segments = explode('.', $key);
        $file_name = array_shift($segments);
        $path = base_path("lang/{$lang_code}/{$file_name}.php");

        if (!file_exists($path))
            return false;

        $translations = include $path;
        $value = Arr::get($translations, implode('.', $segments));
        return $value !== null;
    }

    public static function checkLangIfAvailable(string $lang_code): bool
    {
        $available_locales = config('localization.available_lang_codes') ?? [];
        if (!in_array($lang_code, $available_locales))
            return false;
        return true;
    }

    public static function getDefaultPureTranslation(string $key)
    {
        return __($key, [], config('app.fallback_locale'));
    }

    public static function writeLangFile(string $key, string $value, string $lang_code)
    {
        $segments = explode('.', $key);
        $file_name = array_shift($segments);
        $dir = base_path("lang/{$lang_code}");

        if (!is_dir($dir))
            mkdir($dir, 0755, true);

        $path = $dir . "/{$file_name}.php";

        $translations = file_exists($path) ? include $path : [];

        Arr::set($translations, implode('.', $segments), $value);


        $content = "<?php\n\nreturn " . var_export($translations, true) . ";\n";
        file_put_contents($path, $content);
    }
}
