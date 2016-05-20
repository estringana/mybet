<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class UrlLocalization extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot($events);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    public function getUrl($url = null, $attributes = array() )
    {
        LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale() ,$url, $attributes);
    }
}
