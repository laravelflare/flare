<?php

namespace LaravelFlare\Flare;

use LaravelFlare\Flare\Flare;
use Illuminate\Support\ServiceProvider;

class Flare
{
    /**
     * The Flare version.
     *
     * @var string
     */
    const VERSION = 'alpha';

    /**
     * Array of expected configuration keys
     * with the absolute bare-minimum defaults.
     * 
     * @var array
     */
    protected $configurationKeys = [
        'admin_url' => 'admin',
        'modeladmins' => [],
        'modules' => [],
    ];

    /**
     * __construct
     */
    public function __construct()
    {

    }

    /**
     * Returns Flare configuration values, falling
     * back to the defined bare-minimum configuration
     * defaults if, for whatever reason the config is
     * undefined.
     * 
     * @param  string $key
     * 
     * @return mixed
     */
    public function config($key)
    {
        if (array_key_exists($key, $this->configurationKeys)) {
            return config('flare.'.$key, $this->configurationKeys[$key]);
        }

        return config($key);
    }

    /**
     * Returns URL to a path in the Admin Panel, using the 
     * Admin URL defined in the Flare Config.
     * 
     * @param  string $path
     * 
     * @return string
     */
    public function adminUrl($path = '')
    {
        return url($this->relativeAdminUrl());
    }

    /**
     * Returns URL to a path in the Admin Panel, using the 
     * Admin URL defined in the Flare Config.
     * 
     * @param  string $path
     * 
     * @return string
     */
    public function relativeAdminUrl($path = '')
    {
        return \Flare::config('admin_url') . '/' . $path;
    }

    /**
     * Returns the current Flare Version
     * 
     * @return string
     */
    public function version()
    {
        return self::VERSION;
    }

}
