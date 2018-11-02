<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class CatchServiceProvider extends ServiceProvider
{
    protected $defer = true;
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('catch_utility', function ($app) {
            return new \App\Utilities\CatchUtility();
        });
    }

    public function provides()
    {
        return ['catch_utility'];
    }
}
