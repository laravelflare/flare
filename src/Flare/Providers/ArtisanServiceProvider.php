<?php

namespace LaravelFlare\Flare\Providers;

use Illuminate\Support\ServiceProvider;
use LaravelFlare\Flare\Console\Commands\MakeUserCommand;
use LaravelFlare\Flare\Console\Commands\MakeAdminCommand;
use LaravelFlare\Flare\Console\Commands\Generators\ModelAdminMakeCommand;
use LaravelFlare\Flare\Console\Commands\Generators\ModuleAdminMakeCommand;
use LaravelFlare\Flare\Console\Commands\Generators\WidgetAdminMakeCommand;
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
        'MakeAdmin' => 'command.makeadmin',
        'MakeUser' => 'command.makeuser',
        'ModelAdminMake' => 'command.modeladmin.make',
        'ModuleAdminMake' => 'command.moduleadmin.make',
        'ModelAdminControllerMake' => 'command.modeladmincontroller.make',
        'ModuleAdminControllerMake' => 'command.moduleadmincontroller.make',
        'WidgetAdminMake' => 'command.widgetadmin.make',
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
    protected function registerMakeAdminCommand($command)
    {
        $this->app->singleton($command, function ($app) {
            return new MakeAdminCommand();
        });
    }

    /**
     * Register the command.
     * 
     * @param $command
     * 
     * @return
     */
    protected function registerMakeUserCommand($command)
    {
        $this->app->singleton($command, function ($app) {
            return new MakeUserCommand();
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
        $this->app->singleton($command, function ($app) {
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
        $this->app->singleton($command, function ($app) {
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
    protected function registerModelAdminControllerMakeCommand($command)
    {
        $this->app->singleton($command, function ($app) {
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
        $this->app->singleton($command, function ($app) {
            return new ModuleAdminControllerMakeCommand($app['files']);
        });
    }

    /**
     * Register the command.
     * 
     * @param $command
     * 
     * @return
     */
    protected function registerWidgetAdminMakeCommand($command)
    {
        $this->app->singleton($command, function ($app) {
            return new WidgetAdminMakeCommand($app['files']);
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
