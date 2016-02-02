<?php

namespace LaravelFlare\Flare;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

class FlareServiceProvider extends ServiceProvider
{
    /**
     * Array of Flare Service Providers to be Registered.
     * 
     * @var array
     */
    protected $serviceProviders = [
        \LaravelFlare\Flare\Providers\AuthServiceProvider::class,
        \LaravelFlare\Flare\Providers\ArtisanServiceProvider::class,
        \LaravelFlare\Flare\Providers\EventServiceProvider::class,
        \LaravelFlare\Flare\Providers\RouteServiceProvider::class,
    ];

    /**
     * Array of Flare assets and where they should be published to.
     * 
     * @var array
     */
    protected $assets = [
        'public/flare' => 'vendor/flare',
        'public/AdminLTE/dist' => 'vendor/flare',
        'public/AdminLTE/plugins' => 'vendor/flare/plugins',
        'public/AdminLTE/bootstrap' => 'vendor/flare/bootstrap',
    ];

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishAssets();
        $this->publishConfig();
        $this->publishMigrations();
        $this->publishViews();

        $this->app->bind(
            \LaravelFlare\Flare\Contracts\Permissions\Permissionable::class,
            \Config::get('flare.config.permissions')
        );
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerServiceProviders();
        $this->registerFlareFacade();
    }

    /**
     * Register Service Providers
     *
     * @return void
     */
    protected function registerServiceProviders()
    {
        foreach ($this->serviceProviders as $class) {
            $this->app->register($class);
        }
    }

    /**
     * Register the Flare Facade
     * 
     * @return void
     */
    protected function registerFlareFacade()
    {
        $this->app->singleton('flare', function ($app) {
            return $app->make(\LaravelFlare\Flare\Flare::class);
        });

        AliasLoader::getInstance()->alias('Flare', \LaravelFlare\Flare\Facades\Flare::class);
    }

    /**
     * Publishes the Flare Assets to the appropriate directories.
     * 
     * @return void
     */
    protected function publishAssets()
    {
        $assets = [];

        foreach ($this->assets as $location => $asset) {
            $assets[$this->basePath($location)] = base_path($asset);
        }

        $this->publishes($assets, 'public');
    }

    /**
     * Publishes the Flare Config File
     * 
     * @return void
     */
    protected function publishConfig()
    {
        $this->publishes([
            $this->basePath('config/flare/config.php') => config_path('flare/config.php'),
        ]);
    }

    /**
     * Publishes the Flare Database Migrations
     * 
     * @return void
     */
    protected function publishMigrations()
    {
        $this->publishes([
            $this->basePath('Flare/Database/Migrations') => base_path('database/migrations'),
        ]);
    }

    /**
     * Publishes the Flare Views and defines the location
     * they should be looked for in the application.
     * 
     * @return void
     */
    protected function publishViews()
    {
        $this->loadViewsFrom($this->basePath('resources/views'), 'flare');
        $this->publishes([
            $this->basePath('resources/views') => base_path('resources/views/vendor/flare'),
        ]);
    }

    /**
     * Returns the path to a provided file within the Flare package.
     * 
     * @param  boolean $fiepath 
     * 
     * @return string           
     */
    private function basePath($filepath = false)
    {
        return __DIR__.'/../' . $filepath;
    }
}
