<?php

namespace LaravelFlare\Flare;

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
        'site_title' => 'Laravel <b>Flare</b>',
        'admin_url' => 'admin',
        'admin_theme' => 'red',
        'admin' => [],
        'models' => [],
        'modules' => [],
        'widgets' => [],
        'permissions' => \LaravelFlare\Flare\Permissions\Permissions::class,
        'core_notifications' => true,
    ];

    /**
     * __construct.
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
     * @param string $key
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
        return rtrim(\Flare::config('admin_url').'/'.$path, '/');
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
     * Determines if an AttributeType class exists or not.
     * 
     * @param string $type
     * 
     * @return bool
     */
    public function attributeTypeExists($type)
    {
        if (class_exists('\LaravelFlare\Flare\Admin\Attributes\\'.title_case($type).'Attribute')) {
            return true;
        }

        return false;
    }

    /**
     * Render Attribute.
     *
     * @param string $action
     * @param string $attribute
     * @param string $field
     * @param string $model
     * @param string $modelManager
     *
     * @return \Illuminate\Http\Response
     */
    public function renderAttribute($action, $attribute, $field, $model, $modelManager)
    {
        if (isset($field['type']) && $this->attributeTypeExists($field['type'])) {
            $fieldType = '\LaravelFlare\Flare\Admin\Attributes\\'.$field['type'].'Attribute';

            return call_user_func_array([new $fieldType($attribute, $field, $model, $modelManager), camel_case('render_'.$action)], []);
        }

        return call_user_func_array([new \LaravelFlare\Flare\Admin\Attributes\BaseAttribute($attribute, $field, $model, $modelManager), camel_case('render_'.$action)], []);
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
}
