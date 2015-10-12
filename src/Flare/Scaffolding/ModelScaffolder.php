<?php

namespace LaravelFlare\Flare\Scaffolding;

use Illuminate\Support\Str;
use Illuminate\Console\Command;

class ModelScaffolder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'flare:scaffold:models {--update= : Update an existing Model(s)}';

    /**
     * Are we updating an existing model?
     * 
     * @var boolean
     */
    protected $updating = false;

    /**
     * Model Namespace 
     * 
     * @var string
     */
    protected $namespace = 'App\\';

    /**
     * Array of actions which correlate to methods
     * involved in creating (or updating) a Model 
     * using the Scaffolder. These must be in order.
     * 
     * @var array
     */
    protected $actions = [
                            'defineTable',
                            'defineFillable',
                            'defineHidden',
                            'defineVisible',
                            'enableTimestamps',
                            'enableSoftDeletes',
                            'defineDateFormat',
                            'confirmModelData',
                        ];

    /**
     * Array of Model Data
     * 
     * @var array
     */
    protected $modelData = [];

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {    
        $this->reset();
        
        $this->defineNamespace();

        if ($updateModel = $this->option('update')) {
            $this->update($updateModel);
        } else {
            $this->create();
        }
        
        if ($this->confirmDone()) {
            return;
        }

        $this->handle();
    }

    /**
     * Resets the Model Data for a new Model
     * 
     * @return void
     */
    protected function reset()
    {
        $this->updating = false;
        $this->modelData = [];
    }

    /**
     * Create Model from ClassName
     *
     * @return void
     */
    protected function create()
    {
        $className = $this->defineClassname();

        if (!$className) {
            return;
        }

        $this->info('Adding Model: ' . $className);

        $this->addModelData('classname', $className);

        foreach ($this->actions as $action) {
            call_user_func_array(array($this, $action), []);
        }
    }

    /**
     * Revise the current Model being Scaffolded
     * 
     * @return void
     */
    protected function revise()
    {

    }

    /**
     * Update an existing Model
     *
     * @param mixed $updateModel
     * 
     * @return void
     */
    protected function update($updateModel)
    {

    }

    /**
     * Save the Model Data to the Model File
     *
     * @return void
     */
    protected function save()
    {

    }

    /**
     * Determine if the user wisehs to define a custom
     * namespace for this Model and if they do, have them
     * name it.
     * 
     * @return void
     */
    protected function defineNamespace()
    {
        $this->info('Models will be added to the ' . $this->namespace . ' Namespace.');

        $this->namespace = $this->ask('If this is incorrect please provide your namespace:', $this->namespace);
    }

    /**
     * Determine the Model ClassName
     *
     * If no className provided, ask the user if they are done.
     * 
     * @return string
     */
    protected function defineClassname()
    {
        if ($className = $this->ask('Please provide a class name for your new Model?', false)) {
            return $className;
        } 
    }

    /**
     * Determine if the user wishes to define a custom
     * table for this Model and if they do, have 
     * them name it.
     *
     * @return void
     */
    protected function defineTable()
    {
        $tablename = str_replace('\\', '', Str::snake(Str::plural($this->modelData['classname'])));

        if ($this->confirm('Would you like to define a table for this model?')) {
            $tablename = $this->ask('Please provide a the table name for your Model?', false);
        }

        if ($tablename && $this->confirm('The table name of `'.$tablename.'`, is this correct?')) {
            $this->addModelData('table', $tablename);
            return;
        }

        $this->defineTable();
    } 

    /**
     * Determine if the user wishes to define fillable
     * fields for this Model and if they do, have
     * them define them.
     * 
     * @return void
     */
    protected function defineFillable()
    {
        if ($this->confirm('Would you like to define fillable attributes for this model?')) {
            $this->moreFillable();
        }
    } 

    /**
     * Provide the user with the opportunity to add
     * some aditional fillable attributes
     * 
     * @return void
     */
    protected function moreFillable()
    {
        if($fillable = $this->ask('What fillable attribute would you like to add?', false)) {
            $this->modelData['fillable'][] = $fillable;

            $this->moreFillable();
        }
    }

    /**
     * Determine if the user wishes to define hidden
     * fields for this Model and if they do, have 
     * them define them.
     * 
     * @return void
     */
    protected function defineHidden()
    {
        if ($this->confirm('Would you like to define hidden attributes for this model?')) {
            $this->moreHidden();
        }
    } 

    /**
     * Provide the user with the opportunity to add
     * some aditional hidden attributes
     * 
     * @return void
     */
    protected function moreHidden()
    {
        if($hidden = $this->ask('What hidden attribute would you like to add?', false)) {
            $this->modelData['hidden'][] = $hidden;
            
            $this->defineHidden();
        }
    }

    /**
     * Determine if the user wishes to define visible
     * fields for this Model and if they do, have 
     * them define them.
     * 
     * @return void
     */
    protected function defineVisible()
    {
        if ($this->confirm('Would you like to define visible attributes for this model?')) {
            $this->moreVisible();
        }
    } 

    /**
     * Provide the user with the opportunity to add
     * some aditional visible attributes
     * 
     * @return void
     */
    protected function moreVisible()
    {
        if($visible = $this->ask('What visible attribute would you like to add?', false)) {
            $this->modelData['visible'][] = $visible;

            $this->defineVisible();
        }
    }
    
    /**
     * Ask the user if they would like to enable Timestamps.
     * 
     * @return void
     */
    protected function enableTimestamps()
    {
        if ($this->confirm('Would you like to enabletimestamps on this model?', true)) {
            $this->addModelData('timestamps', true);
            return;
        }

        $this->addModelData('timestamps', false);
    } 

    /**
     * Ask the user if they would like to enable Soft Deletes.
     * 
     * @return void
     */
    protected function enableSoftDeletes()
    {
        if ($this->confirm('Would you like to enable soft deletes?', true)) {
            $this->addModelData('softdeletes', true);
            return;
        }

        $this->addModelData('softdeletes', false);
    } 

    /**
     * Determine if the user wishes to define a 
     * custom date format
     * 
     * @return void
     */
    protected function defineVisible()
    {
        if ($this->confirm('Would you like to define a custom date storage format for this model?')) {
            $this->addModelData('dateFormat', false); // Temp
        }
    } 

    /**
     * Add Model Information to ModelData array
     * 
     * @param string $key  
     * @param mixed $value
     *
     * @return void
     */
    protected function addModelData($key, $value)
    {
        $this->modelData[$key] = $value;
    }

    /**
     * Confirms the Model Data is correct and if it is,
     * saves the file. If it is not, the revise() method
     * will be called (allowing the user to revise their
     * Model Data).
     * 
     * @return void
     */
    protected function confirmModelData()
    {
        $this->info(var_export($this->modelData, true));
        if($this->confirm('Please confirm the Model Data output above is correct.', false)) {
            $this->save();
        }

        $this->revise($this->modelData['classname']);
    }

    /**
     * Confirm if the user is done with creating Models or not.
     *
     * @param mixed $goBack Go back to a certain method, or false
     *                      to go back to the beginning.
     * 
     * @return
     */
    protected function confirmDone($goBack = false)
    {
        if (!$this->confirm('Are you done creating Models?', false)) {
            if ($goBack) {
                call_user_func_array([$this, $goBack], []);
                return;
            } 

            return false;
        }

        return true;
    }
}
