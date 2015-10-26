<?php

namespace LaravelFlare\Flare\Providers;

use Illuminate\Support\ServiceProvider;
use LaravelFlare\Flare\Scaffolding\ScaffoldTester;
use LaravelFlare\Flare\Scaffolding\ModelScaffolder;
use LaravelFlare\Flare\Scaffolding\AdminScaffolder;
use LaravelFlare\Flare\Scaffolding\ScaffoldManager;
use LaravelFlare\Flare\Scaffolding\DatabaseScaffolder;
use LaravelFlare\Flare\Scaffolding\MigrationScaffolder;
use LaravelFlare\Flare\Console\Commands\FlareScaffoldCommand;

class ScaffoldServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * The commands to be registered.
     *
     * @var array
     */
    protected $commands = [
        'FlareScaffoldCommand' => 'command.flare.scaffold',
        'AdminScaffolder' => 'command.flare.scaffold.admin',
        'DatabaseScaffolder' => 'command.flare.scaffold.database',
        'MigrationScaffolder' => 'command.flare.scaffold.migrations',
        'ModelScaffolder' => 'command.flare.scaffold.models',
        'ScaffoldTester' => 'command.flare.scaffold.test',
    ];

    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->app->bind('ScaffoldManager', function () {
            return new ScaffoldManager();
        });

        foreach ($this->commands as $command => $name) {
            $method = "register{$command}";

            call_user_func_array([$this, $method], [$name]);
        }

        $this->commands(array_values($this->commands));
    }

    /**
     * Register the command.
     * 
     * @param $command
     * 
     * @return
     */
    protected function registerFlareScaffoldCommand($command)
    {
        $this->app->singleton($command, function ($app) {
            return new FlareScaffoldCommand($app['ScaffoldManager']);
        });
    }

    /**
     * Register the command.
     * 
     * @param $command
     * 
     * @return
     */
    protected function registerAdminScaffolder($command)
    {
        $this->app->singleton($command, function () {
            return new AdminScaffolder();
        });
    }

    /**
     * Register the command.
     * 
     * @param $command
     * 
     * @return
     */
    protected function registerDatabaseScaffolder($command)
    {
        $this->app->singleton($command, function () {
            return new DatabaseScaffolder();
        });
    }

    /**
     * Register the command.
     * 
     * @param $command
     * 
     * @return
     */
    protected function registerMigrationScaffolder($command)
    {
        $this->app->singleton($command, function () {
            return new MigrationScaffolder();
        });
    }

    /**
     * Register the command.
     * 
     * @param $command
     * 
     * @return
     */
    protected function registerModelScaffolder($command)
    {
        $this->app->singleton($command, function () {
            return new ModelScaffolder();
        });
    }

    /**
     * Register the command.
     * 
     * @param $command
     * 
     * @return
     */
    protected function registerScaffoldTester($command)
    {
        $this->app->singleton($command, function () {
            return new ScaffoldTester();
        });
    }
}
