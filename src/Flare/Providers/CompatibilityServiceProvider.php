<?php

namespace LaravelFlare\Flare\Providers;

use LaravelFlare\Flare\FlareModuleProvider as ServiceProvider;

class CompatibilityServiceProvider extends ServiceProvider
{
    /**
     * Array of Flare Service Providers to be Registered.
     * 
     * @var array
     */
    protected $serviceProviders = [
        'Edge' => [
            \LaravelFlare\Flare\Providers\Edge\RouteServiceProvider::class,
        ],
        'LTS' => [
            \LaravelFlare\Flare\Providers\LTS\RouteServiceProvider::class,
        ],
    ];

    /**
     * Perform post-registration booting of services.
     */
    public function boot()
    {
    }

    /**
     * Register any package services.
     */
    public function register()
    {
        $this->registerServiceProviders();
    }

    /**
     * Register Service Providers.
     */
    protected function registerServiceProviders()
    {
        foreach ($this->serviceProviders[$this->flare->compatibility()] as $class) {
            $this->app->register($class);
        }
    }
}
