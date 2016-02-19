<?php

namespace LaravelFlare\flare\tests;

use Orchestra\Testbench\TestCase;

abstract class BaseTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['path.base'] = __DIR__.'/../../src';
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', array(
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ));
    }

    protected function getPackageProviders($app)
    {
        return [
                \LaravelFlare\Flare\FlareServiceProvider::class,
            ];
    }
}
