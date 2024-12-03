<?php

namespace App\Providers;

use App\Util\Discord;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(\HideHalo\Nanoid\Client::class, fn()=> new \HideHalo\Nanoid\Client());
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Discord::$WEBHOOK = env("DISCORD_WEBHOOK");
    }
}
