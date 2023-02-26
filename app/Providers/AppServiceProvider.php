<?php

namespace App\Providers;

use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
//        if ($this->app->isLocal()) {
//            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
//        }
    }

    public function boot(UrlGenerator $urlGenerator): void
    {
        if (config('app.env') === 'production') {
            $urlGenerator->forceScheme('https');
        }
    }
}
