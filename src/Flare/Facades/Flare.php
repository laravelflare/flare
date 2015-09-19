<?php namespace LaravelFlare\Flare\Facades;

use Illuminate\Support\Facades\Facade;

class Flare extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'flare'; }
}