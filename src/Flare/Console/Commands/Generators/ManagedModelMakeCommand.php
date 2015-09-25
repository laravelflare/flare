<?php

namespace LaravelFlare\Flare\Console\Commands\Generators;

use Illuminate\Console\GeneratorCommand;

class ManagedModelMakeCommand extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:managedmodel';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a new Flare Managed Model class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'ManagedModel';

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
        return __DIR__.'/../../stubs/managed-model.stub';
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
        return $rootNamespace.'\Admin\\Models';
    }
}
