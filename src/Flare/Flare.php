<?php

namespace LaravelFlare\Flare;

use Illuminate\Foundation\Application;

class Flare
{
    /**
     * The Flare version.
     *
     * @var string
     */
    const VERSION = '1.0';

    /**
     * Array of expected configuration keys
     * with the absolute bare-minimum defaults.
     * 
     * @var array
     */
    protected $configurationKeys = [
        'admin_title' => 'Laravel Flare',
        'admin_url' => 'admin',
        'admin_theme' => 'red',
        'admin' => [],
        'attributes' => [],
        'models' => [],
        'modules' => [],
        'widgets' => [],
        'permissions' => \LaravelFlare\Flare\Permissions\Permissions::class,
        'policies' => [],
        'show' => [
            'github' => true,
            'login' => true,
            'notifications' => true,
            'version' => true,
        ],
    ];

    /**
     * Array of Helper Methods.
     *
     * @var array
     */
    protected $helpers = [
        'admin' => \LaravelFlare\Flare\Admin\AdminManager::class,
        'permissions' => \LaravelFlare\Flare\Contracts\Permissions\Permissionable::class,
    ];

    /**
     * Application Instance.
     * 
     * @var \Illuminate\Foundation\Application
     */
    protected $app;

    /**
     * Flare Configuration.
     * 
     * @var array
     */
    protected $config;

    /**
     * The Title of the Admin Panel.
     * 
     * @var string
     */
    protected $adminTitle;

    /**
     * Safe Title of the Admin Panel.
     * 
     * @var string
     */
    protected $safeAdminTitle;

    /**
     * Relative Base URL of Admin Panel.
     * 
     * @var string
     */
    protected $relativeAdminUrl;

    /**
     * __construct.
     *
     * @param \Illuminate\Foundation\Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;

        $this->setLoadedConfig();
    }

    /**
     * Returns the Application Instance.
     * 
     * @return mixed
     */
    public function app()
    {
        return $this->app;
    }

    /**
     * Returns a Flare configuration value(s).
     * 
     * @param string $key
     * 
     * @return mixed
     */
    public function config($key)
    {
        return $this->getConfig($key);
    }

    /**
     * Returns a Flare configuration value(s), falling back 
     * to the defined bare-minimum configuration defaults 
     * if, for whatever reason the config is undefined.
     * 
     * @param string $key
     * 
     * @return mixed
     */
    public function getConfig($key)
    {
        if (array_key_exists($key, $this->config)) {
            return $this->config[$key];
        }

        return config('flare.'.$key);
    }

    /**
     * Allow setting of the Flare config at runtime.
     */
    public function setConfig()
    {
    }

    /**
     * Set the loaded config to the protected property.
     *
     * Defaults to the configuration provided in this file 
     * (the bare minimum) if no config is found available.
     */
    public function setLoadedConfig()
    {
        if (!config('flare.config')) {
            $this->config = $this->configurationKeys;

            return;
        }

        $this->config = config('flare.config');
    }

    /**
     * @return string
     * 
     * @deprecated 0.9 Use getAdminTitle() instead.
     */
    public function adminTitle()
    {
        return $this->getAdminTitle();
    }

    /**
     * Returns the defined Admin Title.
     *
     * @return string
     */
    public function getAdminTitle()
    {
        return $this->adminTitle ? $this->adminTitle : \Flare::config('admin_title');
    }

    /**
     * Sets the Admin Title.
     * 
     * @param mixed $title
     */
    public function setAdminTitle($title = null)
    {
        $this->adminTitle = $title;
    }

    /**
     * @return string
     * 
     * @deprecated 0.9 Use getSafeAdminTitle() instead.
     */
    public function safeAdminTitle()
    {
        return $this->getSafeAdminTitle();
    }

    /**
     * Returns the defined Admin Title, converted
     * to a safer format (for <title> tags etc.).
     * 
     * @return string
     */
    public function getSafeAdminTitle()
    {
        return $this->safeAdminTitle ? $this->adminTitle : strip_tags(\Flare::config('admin_title'));
    }

    /**
     * Sets the Safe Admin Title which is used 
     * in <title> tags etc.
     *
     * @param mixed $title
     */
    public function setSafeAdminTitle($title = null)
    {
        $this->safeAdminTitle = $title;
    }

    /**
     * Returns URL to a path in the Admin Panel, using the 
     * Admin URL defined in the Flare Config.
     * 
     * @param string $path
     * 
     * @return string
     */
    public function adminUrl($path = '')
    {
        return url($this->relativeAdminUrl($path));
    }

    /**
     * Returns URL to a path in the Admin Panel, using the 
     * Admin URL defined in the Flare Config.
     * 
     * @param string $path
     * 
     * @return string
     */
    public function relativeAdminUrl($path = '')
    {
        return rtrim($this->getRelativeAdminUrl().'/'.$path, '/');
    }

    /**
     * Returns URL to a path in the Admin Panel, using the 
     * Admin URL defined in the Flare Config.
     * 
     * @return string
     */
    public function getRelativeAdminUrl()
    {
        return $this->relativeAdminUrl ? $this->relativeAdminUrl : \Flare::config('admin_url');
    }

    /**
     * Set the Flare Relative Admin URL.
     *
     * If the provided path is null the relative path provided
     * with the getRelativeAdminUrl() method will return the
     * configuration file default (or the Flare fallbacks).
     * 
     * @param mixed $path
     */
    public function setRelativeAdminUrl($path = null)
    {
        $this->relativeAdminUrl = $path;
    }

    /**
     * Returns URL to a path in the Flare Documentation.
     * This is COMING SOON!
     * 
     * @param string $path
     * 
     * @return string
     */
    public function docsUrl($path = '')
    {
        return url('#'.$path);
    }

    /**
     * Takes a named route inside the Flare namespace
     * and returns the URL.
     * 
     * @return string
     */
    public function route()
    {
    }

    /**
     * Determines whether part of the Flare Admin Panel
     * should be displayed or not and returns true / false.
     * 
     * @param string $key
     * 
     * @return bool
     */
    public function show($key = false)
    {
        if (!$key) {
            return false;
        }

        return $this->getShow($key);
    }

    /**
     * Determines whether part of the Flare Admin Panel
     * should be displayed or not and returns true / false.
     *
     * Accessor for getShow().
     * 
     * @param string $key
     * 
     * @return bool
     */
    public function getShow($key = false)
    {
        if (array_key_exists($key, $showConfig = $this->getConfig('show'))) {
            return $showConfig[$key];
        }
    }

    /**
     * Returns the current Flare Version.
     * 
     * @return string
     */
    public function version()
    {
        return self::VERSION;
    }

    /**
     * Returns the compatibility version of Flare to use.
     *
     * This will either return 'LTS' for Laravel installs of
     * the Long Term Support branch (5.1.x) or 'Edge' for all
     * other versions (including dev-master).
     * 
     * @return string
     */
    public function compatibility()
    {
        if (strpos($this->app->version(), '5.1.') !== false && strpos($this->app->version(), '(LTS)') !== false) {
            return 'LTS';
        }

        return 'Edge';
    }

    /**
     * Register a helper method.
     */
    public function registerHelper($helper, $class)
    {
        if (array_key_exists($helper, $this->helpers)) {
            throw new Exception("Helper method `$helper` has already been defined");
        }

        $this->helpers[$helper] = $class;
    }

    /**
     * Unregister a helper method.
     *
     * @param string $helper
     */
    public function unregisterHelper($helper)
    {
        unset($this->helpers[$helper]);
    }

    /**
     * Call a Helper Method.
     * 
     * @param string $method
     * @param mixed  $parameters
     * 
     * @return mixed
     */
    protected function callHelperMethod($method, $parameters)
    {
        return $this->app->make($this->helpers[$method], $parameters);
    }

    /**
     * Provide access to Helper Methods.
     *
     * This provides an extensible way of adding helper classes
     * which are registerable and available to adccess through
     * the Flare Facade.
     *
     * @param string $method
     * @param array  $parameters
     * 
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        if (array_key_exists($method, $this->helpers)) {
            return $this->callHelperMethod($method, $parameters);
        }

        return call_user_func_array([$this, $method], $parameters);
    }
}
