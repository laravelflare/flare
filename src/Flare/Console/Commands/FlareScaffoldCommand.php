<?php

namespace LaravelFlare\Flare\Console\Commands;

use Illuminate\Console\Command;
use LaravelFlare\Flare\Scaffolding\ScaffoldManager;

class FlareScaffoldCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'flare:scaffold 
                                    {--update : Skips the Model creation stage of the Scaffolder} 
                                    {--admin : Skips the Model creation and amendment stages of the Scaffolder}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Flare Scaffolding rapidly creates Models, Migrations, ModelAdmins (Admin based Model Managers) into your application';

    /**
     * ScaffoldManager Instance
     * 
     * @var \LaravelFlare\Flare\Scaffolding\ScaffoldManager
     */
    protected $scaffold;

    /**
     * @param \LaravelFlare\Flare\Scaffolding\ScaffoldManager $scaffold
     * 
     * __construct.
     */
    public function __construct(ScaffoldManager $scaffold)
    {
        $this->scaffold = $scaffold;

        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * Determines whether to start with the Admin Scaffolder
     * (which consists of just creating ModelAdmin classes),
     * the Update Scaffolder (which allows updating existing Models,
     * create migrations, scaffolding ModelAdmin classes and
     * creating database seeders of faker data) or the full
     * scaffolding suite (which consists of all the aforementioned
     * functionality plus the ability to create new app models
     * and run the scaffolder test suite against your application).
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Starting the Flare Scaffolding Command...');

        if ($this->option('admin')) {
            $this->admin();
            return;
        }

        if ($this->option('update')) {
            $this->update();
            return;
        }
        
        $this->scaffold();
    }

    /**
     * Asks the user if they wish to create any new Models,
     * if they do, fire off the newModels scaffolder.
     *
     * Once all models are created, the update models scaffolder
     * is triggered (which consists of several other actions).
     *
     * Finally, the scaffolder tests method is run (which asks
     * the user if they wish to run teh scaffolder tests or not).
     * 
     * @return void
     */
    private function scaffold()
    {
        if ($this->confirm('Would you like to create any new models for your application?', 'y')) {
            $this->scaffold->newModels();
        }

        $this->update();
        
        $this->tests();
    }

    /**
     * Asks the user if they would like to update any Models in their 
     * application and if they do fires of the existingModels scaffolder.
     *
     * After this is complete the migrations scaffolder is fired, 
     * followed by the model admin scaffolder and finally the 
     * database seeder scaffolder.
     * 
     * @return void
     */
    private function update()
    {
        if ($this->confirm('Would you like to update any models in your application?', 'y')) {
            $this->scaffold->existingModels();
        }

        $this->migrations();

        $this->admin();

        $this->seed();
    }

    /**
     * Asks the user if they wish to create any migrations and if they do,
     * fires off the migration scaffolder functionality.
     * 
     * @return void
     */
    private function migrations()
    {
        if ($this->confirm('Would you like to create any migrations for your application?', 'y')) {
            $this->scaffold->migrations();
        }
    }

    /**
     * Asks the user if they wish to create any model admin classes and
     * if they do fires off the model admin scaffolder functionality.
     * 
     * @return void
     */
    private function admin()
    {
        if ($this->confirm('Would you like to create any model admin functionality for your application?', 'y')) {
            $this->scaffold->modelAdmins();
        }
    }

    /**
     * Asks the user if they wish to create any database seeders 
     * and if they do, fire off the database seed scaffolder.
     * 
     * @return void
     */
    private function seed()
    {
        if ($this->confirm('Would you like to create any fake data seeders for your application?', 'y')) {
            $this->scaffold->seeders();
        }
    }

    /**
     * Asks the user if they wish to run the scaffold test suite
     * against the users application and if they do, fires of the
     * test suite. 
     *
     * The test suite consists of testing that Model Attributes 
     * match their migration and Model Admin field types.
     * 
     * @return void
     */
    private function tests()
    {
        if ($this->confirm('Would you like to run the model admin test suite against your models?', 'y')) {
            $this->scaffold->tests();
        }
    }
}
