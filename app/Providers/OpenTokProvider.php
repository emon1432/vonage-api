<?php

namespace App\Providers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;
use OpenTok\OpenTok;

class OpenTokProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        //

        $this->app->singleton(OpenTok::class, function ($app) {
            return new OpenTok($_ENV['OPENTOK_KEY'], $_ENV['OPENTOK_SECRET']);
        });

        Config::set('OPENTOK_KEY', $_ENV['OPENTOK_KEY']);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
