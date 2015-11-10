<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Extentions\ConfigUserProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if ( \DB::getDriverName() == 'sqlite' ) {
            \DB::statement('PRAGMA foreign_keys=1');
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
