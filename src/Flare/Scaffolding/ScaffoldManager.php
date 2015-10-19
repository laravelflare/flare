<?php

namespace LaravelFlare\Flare\Scaffolding;

class ScaffoldManager
{
    /**
     * __construct.
     */
    public function __construct()
    {
    }

    /**
     * Scaffold New Models.
     */
    public function newModels()
    {
        passthru('php artisan flare:scaffold:models');
    }

    /**
     * Scaffold Existing Models.
     */
    public function existingModels()
    {
        passthru('php artisan flare:scaffold:models --update');
    }

    /**
     * Scaffold Migrations.
     */
    public function migrations()
    {
        passthru('php artisan flare:scaffold:migrations');
    }

    /**
     * Scaffold Model Admin.
     */
    public function modelAdmins()
    {
        passthru('php artisan flare:scaffold:admin');
    }

    /**
     * Scaffold Database Seeders.
     */
    public function seeders()
    {
        passthru('php artisan flare:scaffold:database');
    }

    /**
     * Run Scaffolding Test Suite.
     */
    public function tests()
    {
        passthru('php artisan flare:scaffold:test');
    }
}
