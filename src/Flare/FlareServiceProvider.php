<?php

namespace LaravelFlare\Flare;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

class FlareServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     */
    public function boot()
    {
        // Assets
        $this->publishes([
            __DIR__.'/../public/flare' => public_path('vendor/flare'),
            __DIR__.'/../public/AdminLTE/bootstrap' => public_path('vendor/flare/bootstrap'),
            __DIR__.'/../public/AdminLTE/dist' => public_path('vendor/flare'),
            __DIR__.'/../public/AdminLTE/plugins' => public_path('vendor/flare/plugins'),
        ], 'public');

        // Config
        $this->publishes([
            __DIR__.'/../config/flare.php' => config_path('flare.php'),
        ]);

        // Database Migrations
        $this->publishes([
            __DIR__.'/Database/Migrations' => base_path('database/migrations'),
        ]);

        // Binds the Permissions interface to the defined Permissions class
        $this->app->bind(\LaravelFlare\Flare\Contracts\Permissions\Permissionable::class, \Flare::config('permissions'));

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

        $this->app->singleton('flare', function () {
            return new Flare();
        });

        $loader = AliasLoader::getInstance();
        $loader->alias('Flare', \LaravelFlare\Flare\Facades\Flare::class);
    }

    /**
     * Register Service Providers.
     */
    protected function registerServiceProviders()
    {
        \App::register('LaravelFlare\Flare\Providers\AuthServiceProvider');
        \App::register('LaravelFlare\Flare\Providers\ArtisanServiceProvider');
        \App::register('LaravelFlare\Flare\Providers\EventServiceProvider');
        \App::register('LaravelFlare\Flare\Providers\RouteServiceProvider');
    }

    /**
     * Register Blade Operators.
     */
    protected function registerBladeOperators()
    {
    }
}
