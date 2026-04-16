<?php

namespace App\Providers;

use App\Models\CompraItem;
use App\Observers\CompraObserver;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Forzar HTTPS cuando la APP_URL usa https
        if (str_starts_with(config('app.url'), 'https://')) {
            URL::forceScheme('https');
        }

        CompraItem::observe(CompraObserver::class);
    }
}
