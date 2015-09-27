<?php

namespace LaravelFlare\Flare\Console\Commands\Generators;

use Illuminate\Console\GeneratorCommand;

class WidgetAdminMakeCommand extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:widgetadmin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a new Flare Widget Admin class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'WidgetAdmin';

    /**
     * Execute the command.
     */
    public function fire()
    {
        parent::fire();
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__.'/../../stubs/widget-admin.stub';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param string $rootNamespace
     * 
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\Admin\\Widgets';
    }
}
