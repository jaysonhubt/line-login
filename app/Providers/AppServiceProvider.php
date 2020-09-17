<?php

namespace App\Providers;

use App\Http\Controllers\LineController;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use LINE\LINEBot;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(LINEBot::class, function () {
            return new LINEBot(
                new CurlHTTPClient(LineController::CHANNEL_TOKEN),
                ['channelSecret' => LineController::CHANNEL_SECRET]
            );
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (env('APP_ENV') === 'production' || env('APP_ENV') === 'stg') {
            URL::forceScheme('https');
        }
    }
}
