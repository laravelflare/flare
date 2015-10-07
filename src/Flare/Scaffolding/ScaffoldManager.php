<?php

namespace LaravelFlare\Flare\Scaffolding;

use LaravelFlare\Flare\Scaffolding\ScaffoldTester;
use LaravelFlare\Flare\Scaffolding\AdminScaffolder;
use LaravelFlare\Flare\Scaffolding\ModelScaffolder;
use LaravelFlare\Flare\Scaffolding\DatabaseScaffolder;
use LaravelFlare\Flare\Scaffolding\MigrationScaffolder;

class ScaffoldManager
{ 
    /**
     * Model Scaffolder
     * 
     * @var \LaravelFlare\Flare\Scaffolding\ModelScaffolder
     */
    protected $models; 

    /**
     * Model Scaffolder
     * 
     * @var \LaravelFlare\Flare\Scaffolding\MigrationScaffolder
     */
    protected $migrations; 

    /**
     * Model Scaffolder
     * 
     * @var \LaravelFlare\Flare\Scaffolding\AdminScaffolder
     */
    protected $admin; 

    /**
     * Model Scaffolder
     * 
     * @var \LaravelFlare\Flare\Scaffolding\DatabaseScaffolder
     */
    protected $database; 

    /**
     * Model Scaffolder
     * 
     * @var \LaravelFlare\Flare\Scaffolding\ScaffoldTester
     */
    protected $tests;

    /**
     * __construct
     * 
     * @param ModelScaffolder     $models    
     * @param MigrationScaffolder $migrations
     * @param AdminScaffolder     $admin     
     * @param DatabaseScaffolder  $database  
     * @param ScaffoldTester      $tests     
     */
    public function __construct(ModelScaffolder $models, MigrationScaffolder $migrations, AdminScaffolder $admin, DatabaseScaffolder $database, ScaffoldTester $tests)
    {
        $this->models = $models;
        $this->migrations = $migrations;
        $this->admin = $admin;
        $this->database = $database;
        $this->tests = $tests;
    }

    /**
     * Scaffold New Models
     * 
     * @return void
     */
    public function newModels()
    {

    }

    /**
     * Scaffold Existing Models
     * 
     * @return void
     */
    public function existingModels()
    {

    }

    /**
     * Scaffold Migrations
     * 
     * @return void
     */
    public function migrations()
    {

    }

    /**
     * Scaffold Model Admin
     * 
     * @return void
     */
    public function modelAdmins()
    {

    }

    /**
     * Scaffold Database Seeders
     * 
     * @return void
     */
    public function seeders()
    {

    }

    /**
     * Run Scaffolding Test Suite
     * 
     * @return void
     */
    public function tests()
    {

    }
}
