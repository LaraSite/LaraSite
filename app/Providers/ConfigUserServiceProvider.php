<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Extentions\ConfigUserProvider;

class ConfigUserServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        \Auth::extend('config', function($app) {
            return new ConfigUserProvider();
        });
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
}
