<?php

namespace JacobBaileyLtd\Flare;

use Illuminate\Support\ServiceProvider;

class FlareServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     */
    public function boot(\Illuminate\Routing\Router $router)
    {
        // Assets
        $this->publishes([
            __DIR__.'/../public/' => public_path('vendor/flare'),
            __DIR__.'/../../vendor/twbs/bootstrap/dist' => public_path('vendor/bootstrap'),
        ], 'public');

        // Config - I would prefer to call this something self-descriptive, such as 'admin.php'
        $this->publishes([
            __DIR__.'/../config/flare.php' => config_path('flare.php'),
        ]);

        // Middleware
        $router->middleware('flareauthenticate', 'JacobBaileyLtd\Flare\Http\Middleware\FlareAuthenticate');
        $router->middleware('checkpermissions', 'JacobBaileyLtd\Flare\Http\Middleware\CheckPermissions');

        // Routes
        if (!$this->app->routesAreCached()) {
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
     */
    public function register()
    {
        // Merge Config 
        $this->mergeConfigFrom(
            __DIR__.'/../config/flare.php', 'flare'
        );
    }
}
