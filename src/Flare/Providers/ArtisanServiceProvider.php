<?php

namespace LaravelFlare\Flare\Providers;

use Illuminate\Support\ServiceProvider;
use LaravelFlare\Flare\Console\Commands\CreateUserCommand;
use LaravelFlare\Flare\Console\Commands\Generators\ModelAdminMakeCommand;
use LaravelFlare\Flare\Console\Commands\Generators\ModuleAdminMakeCommand;
use LaravelFlare\Flare\Console\Commands\Generators\ManagedModelMakeCommand;
use LaravelFlare\Flare\Console\Commands\Generators\ModelAdminControllerMakeCommand;
use LaravelFlare\Flare\Console\Commands\Generators\ModuleAdminControllerMakeCommand;

class ArtisanServiceProvider extends ServiceProvider
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
        'CreateUser' => 'command.createuser',
        'ModelAdminMake' => 'command.modeladmin.make',
        'ModuleAdminMake' => 'command.moduleadmin.make',
        'ManagedModelMake' => 'command.managedmodel.make',
        'ModelAdminControllerMake' => 'command.modeladmincontroller.make',
        'ModuleAdminControllerMake' => 'command.moduleadmincontroller.make',
    ];

    /**
     * Register the service provider.
     */
    public function register()
    {
        foreach ($this->commands as $command => $name) {
            $method = "register{$command}Command";

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
    protected function registerCreateUserCommand($command)
    {
        $this->app->singleton($command, function($app) {
            return new CreateUserCommand($app['files']);
        });
    }

    /**
     * Register the command.
     * 
     * @param $command
     * 
     * @return
     */
    protected function registerModelAdminMakeCommand($command)
    {
        $this->app->singleton($command, function($app) {
            return new ModelAdminMakeCommand($app['files']);
        });
    }

    /**
     * Register the command.
     * 
     * @param $command
     * 
     * @return
     */
    protected function registerModuleAdminMakeCommand($command)
    {
        $this->app->singleton($command, function($app) {
            return new ModuleAdminMakeCommand($app['files']);
        });
    }

    /**
     * Register the command.
     * 
     * @param $command
     * 
     * @return
     */
    protected function registerManagedModelMakeCommand($command)
    {
        $this->app->singleton($command, function($app) {
            return new ManagedModelMakeCommand($app['files']);
        });
    }

    /**
     * Register the command.
     * 
     * @param $command
     * 
     * @return
     */
    protected function registerModelAdminControllerMakeCommand($command)
    {
        $this->app->singleton($command, function($app) {
            return new ModelAdminControllerMakeCommand($app['files']);
        });
    }

    /**
     * Register the command.
     * 
     * @param $command
     * 
     * @return
     */
    protected function registerModuleAdminControllerMakeCommand($command)
    {
        $this->app->singleton($command, function($app) {
            return new ModuleAdminControllerMakeCommand($app['files']);
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array_values($this->commands);
    }
}
