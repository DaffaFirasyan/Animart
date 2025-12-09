<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        if ($this->app->environment('production')) {
            $this->app->useStoragePath(env('APP_STORAGE_PATH', '/tmp/storage'));
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
    if ($this->app->environment('production', 'staging')) {
        URL::forceScheme('https');
    }
    }
}
