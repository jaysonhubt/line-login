<?php

namespace App\Providers;

use App\Http\Controllers\LineController;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use LINE\LINEBot;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;

class AppServiceProvider extends ServiceProvider
{
    const CHANNEL_TOKEN = '9HtT9mHDETFdiWrXX8xTmjauaOMiHDI4IaavUBX59ftcLtkuo64C3TI1g43OxY8Ksq+yBDl5ZeNIfOxlnmSFy6VYubNLTvKxMjQxwVTV1zZiRQUyrmpUmJTjUsXwrjqx02YjHTrZh/AqAE0xK5U6LgdB04t89/1O/w1cDnyilFU=';
    const CHANNEL_SECRET = 'ec46fc50e1dbfa160360eae8767d8831';

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(LINEBot::class, function ($app) {
            return new LINEBot(
                new CurlHTTPClient(self::CHANNEL_TOKEN),
                ['channelSecret' => self::CHANNEL_SECRET]
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
