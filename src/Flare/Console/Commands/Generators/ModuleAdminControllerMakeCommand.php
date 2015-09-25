<?php

namespace LaravelFlare\Flare\Console\Commands\Generators;

use Illuminate\Console\GeneratorCommand;

class ModuleAdminControllerMakeCommand extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:moduleadmincontroller';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a new Flare Module Admin Controller class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'ModuleAdminController';

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
        return __DIR__.'/../../stubs/module-admin-controller.stub';
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
        return $rootNamespace.'\Admin\\Http\\Controllers';
    }
}
