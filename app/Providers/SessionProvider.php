<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class SessionProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        return require_once app_path().'/Helper/SessionCheck.php';
    }
}
