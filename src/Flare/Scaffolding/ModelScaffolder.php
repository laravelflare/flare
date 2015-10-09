<?php

namespace LaravelFlare\Flare\Scaffolding;

use Illuminate\Console\Command;

class ModelScaffolder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'flare:scaffold:models';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->fire();
    }

    /**
     * Fire!
     * 
     * @return void
     */
    public function fire()
    {
        if ($className = $this->ask('Please provide a class name for your new Model?', false)) {
            $this->info('Added classname: ' . $className);
        } else if ($this->confirm('Are you done creating Models?', false)) {
            return;
        }

        $this->fire();
    }
}
