<?php

namespace LaravelFlare\Flare\Console\Commands;

use Illuminate\Console\Command;

class FlareInstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'flare:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install Flare into the application';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        passthru('php artisan vendor:publish --provider="LaravelFlare\Flare\FlareServiceProvider"');

        $this->table(
            ['Task', 'Status'],
            [
                ['Installing Flare', '<info>✔</info>'],
            ]
        );

        if ($this->confirm('Would you like to run the Flare Scaffolder?', 'yes')) {
            passthru('php artisan flare:scaffold');
        }
    }
}
