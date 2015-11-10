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
        try {
            if ( \DB::getDriverName() == 'sqlite' ) {
                \DB::statement('PRAGMA foreign_keys=1');
            }
        } catch (\PDOException $e) {
            // Ignore the exception
            // Because DB may not yet been set up.
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
