<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class Localization
{
    public function handle(Request $request, Closure $next): Response
    {
        $requested_locale = $request->header('Accept-Language');
        if ($requested_locale !== config('app.locale') && in_array($requested_locale, config('localization.available_lang_codes')))
            App::setLocale($requested_locale);

        return $next($request);
    }
}
