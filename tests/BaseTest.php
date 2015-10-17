<?php

namespace LaravelFlare\Flare\Tests;

use Orchestra\Testbench\TestCase;
use Symfony\Component\Console\Output\BufferedOutput;

abstract class BaseTest extends TestCase
{

    public function setUp()
    {
        parent::setUp();
        
        // $artisan = $this->app->make('artisan');
        // $output = new BufferedOutput;
        // $artisan->call('migrate', [
        //                                 '--database' => 'testbench',
        //                                 '--path'     => 'migrations',
        //                             ], $output);
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['path.base'] = __DIR__ . '/../../src';
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', array(
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ));
    }

    protected function getPackageProviders($app)
    {
        return [
                \LaravelFlare\Flare\FlareServiceProvider::class,
            ];
    }
}
