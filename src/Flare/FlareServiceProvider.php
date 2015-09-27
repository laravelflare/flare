<?php

namespace LaravelFlare\Flare;

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
        ], 'public');

        // Config - I would prefer to call this something self-descriptive, such as 'admin.php'
        $this->publishes([
            __DIR__.'/../config/flare.php' => config_path('flare.php'),
        ]);

        // Middleware
        $router->middleware('flareauthenticate', 'LaravelFlare\Flare\Http\Middleware\FlareAuthenticate');
        $router->middleware('checkmodelfound', 'LaravelFlare\Flare\Http\Middleware\CheckModelFound');
        $router->middleware('checkpermissions', 'LaravelFlare\Flare\Http\Middleware\CheckPermissions');

        // Routes
        if (!$this->app->routesAreCached()) {
            require __DIR__.'/Http/routes.php';
        }

        // Views
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'flare');
        $this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/flare'),
        ]);

        $this->registerBladeOperators();
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

        $this->registerServiceProviders();

        $this->app->singleton('flare', function($app) {
            return new Flare($app);
        });

        $loader = \Illuminate\Foundation\AliasLoader::getInstance();
        $loader->alias('Flare', \LaravelFlare\Flare\Facades\Flare::class);
    }

    /**
     * Register Service Providers.
     */
    public function registerServiceProviders()
    {
        \App::register('LaravelFlare\Flare\Providers\ArtisanServiceProvider');
    }

    /**
     * Register Blade Operators.
     */
    public function registerBladeOperators()
    {
    }
}
