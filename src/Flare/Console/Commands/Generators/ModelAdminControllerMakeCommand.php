<?php

namespace LaravelFlare\Flare\Console\Commands\Generators;

use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputArgument;

class ModelAdminControllerMakeCommand extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:modeladmincontroller';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a new Flare Model Admin Controller class';
   
    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'ModelAdminController';

    /**
     * Execute the command.
     *
     * @return void
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
        return __DIR__.'/../../stubs/model-admin-controller.stub';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * 
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\Admin\\Http\\Controllers';
    }
}