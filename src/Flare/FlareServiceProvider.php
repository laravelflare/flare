<?php

namespace AdenFraser\Flare;

use Illuminate\Support\ServiceProvider;

class FlareServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        // Assets
        $this->publishes([
            __DIR__.'/../public/' => public_path('vendor/flare'),
            __DIR__.'/../../vendor/twbs/bootstrap/dist' => public_path('vendor/bootstrap'),
        ], 'public');

        // Routes
        if (! $this->app->routesAreCached()) {            
            require __DIR__.'/Http/routes.php';
        }

        // Views
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'flare');
        $this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/flare'),
        ]);
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}