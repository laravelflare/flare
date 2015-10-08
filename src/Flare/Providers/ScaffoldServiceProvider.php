<?php

namespace LaravelFlare\Flare\Providers;

use Illuminate\Support\ServiceProvider;
use LaravelFlare\Flare\Scaffolding\ScaffoldTester;
use LaravelFlare\Flare\Scaffolding\ModelScaffolder;
use LaravelFlare\Flare\Scaffolding\AdminScaffolder;
use LaravelFlare\Flare\Scaffolding\ScaffoldManager;
use LaravelFlare\Flare\Scaffolding\DatabaseScaffolder;
use LaravelFlare\Flare\Scaffolding\MigrationScaffolder;

class ScaffoldServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->app->bind('ModelScaffolder', function ($app) {
            return new ModelScaffolder();
        });

        $this->app->bind('MigrationScaffolder', function ($app) {
            return new MigrationScaffolder();
        });

        $this->app->bind('AdminScaffolder', function ($app) {
            return new AdminScaffolder();
        });

        $this->app->bind('DatabaseScaffolder', function ($app) {
            return new DatabaseScaffolder();
        });

        $this->app->bind('ScaffoldTester', function ($app) {
            return new ScaffoldTester();
        });

        $this->app->bind('ScaffoldManager', function ($app) {
            return new ScaffoldManager(
                                                                        $app['ModelScaffolder'],
                                                                        $app['MigrationScaffolder'],
                                                                        $app['AdminScaffolder'],
                                                                        $app['DatabaseScaffolder'],
                                                                        $app['ScaffoldTester']
                                                                    );
        });
    }
}
