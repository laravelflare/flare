<?php

namespace LaravelFlare\Flare\Scaffolding;

class ScaffoldManager
{
    /**
     * __construct
     */
    public function __construct()
    {

    }

    /**
     * Scaffold New Models
     * 
     * @return void
     */
    public function newModels()
    {
        passthru('php artisan flare:scaffold:models');
    }

    /**
     * Scaffold Existing Models
     * 
     * @return void
     */
    public function existingModels()
    {
        passthru('php artisan flare:scaffold:models --update');
    }

    /**
     * Scaffold Migrations
     * 
     * @return void
     */
    public function migrations()
    {
        passthru('php artisan flare:scaffold:migrations');
    }

    /**
     * Scaffold Model Admin
     * 
     * @return void
     */
    public function modelAdmins()
    {
        passthru('php artisan flare:scaffold:admin');
    }

    /**
     * Scaffold Database Seeders
     * 
     * @return void
     */
    public function seeders()
    {
        passthru('php artisan flare:scaffold:database');
    }

    /**
     * Run Scaffolding Test Suite
     * 
     * @return void
     */
    public function tests()
    {
        passthru('php artisan flare:scaffold:test');
    }
}
