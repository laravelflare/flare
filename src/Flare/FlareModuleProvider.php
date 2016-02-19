<?php

namespace LaravelFlare\Flare;

use Illuminate\Support\ServiceProvider;

class FlareModuleProvider extends ServiceProvider
{
    /**
     * Flare
     * 
     * @var \LaravelFlare\Flare\Flare
     */
    protected $flare;

    /**
     * Create a new service provider instance.
     *
     * @param  \Illuminate\Contracts\Foundation\Application  $app
     * @return void
     */
    public function __construct($app)
    {
        parent::__construct($app);

        $this->flare = $this->app->make('flare');
    }
    
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
        
    }
}
