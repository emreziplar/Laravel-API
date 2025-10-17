<?php

namespace App\Providers;

use App\Models\Eloquent\User;
use App\Services\Localization\LocalizationService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        class_alias(User::class, \App\Models\User::class);

        $this->app->singleton(LocalizationService::class, function () {
            return new LocalizationService(config('localization.drivers'));
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
