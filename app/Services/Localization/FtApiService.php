<?php

namespace App\Services\Localization;

use App\Contracts\Localization\ILocalizationService;
use Illuminate\Support\Facades\Http;

class FtApiService implements ILocalizationService
{
    public const API_URL = 'https://ftapi.pythonanywhere.com/translate';
    public const TIMEOUT = 10;

    public function translate(string $text, string $destination_lang_code = 'en', string $source_lang_code = 'en'): ?string
    {
        try {
            $response = Http::timeout(self::TIMEOUT)->get(self::API_URL, [
                'sl' => $source_lang_code,
                'dl' => $destination_lang_code,
                'text' => $text
            ]);

            if ($response->successful()) {

                $data = $response->json();
                return $data['destination-text'] ?? null;
            }

            return null;
        } catch (\Exception $ex) {
            return null;
        }
    }
}
