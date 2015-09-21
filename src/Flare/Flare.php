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
        'site_title' => 'Laravel <b>Flare</b>',
        'admin_url' => 'admin',
        'admin_theme' => 'red',
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
     * Determines if an AttributeType class exists or not.
     * 
     * @param  string $type 
     * 
     * @return boolean       
     */
    public function attributeTypeExists($type)
    {
        if (class_exists('\LaravelFlare\Flare\Admin\Attributes\\'.$type.'Attribute')) {
            return true;
        }

        return false;
    }

    /**
     * Returns the Add Attribute Rendered View.
     *
     * Attributes should really be registered in an AttributeServiceProvider and/or
     * the Flare Configuration file, so that they can be expanded on, overridden etc.
     * 
     * @param  string $attribute   
     * @param  string $field 
     * @param  string $model 
     * 
     * @return        
     */
    public function addAttribute($attribute, $field)
    {
        if (isset($field['type']) && $this->attributeTypeExists($field['type'])) {
            $fieldType = '\LaravelFlare\Flare\Admin\Attributes\\' . $field['type'] . 'Attribute';

            return (new $fieldType($attribute, $field))->renderAdd();
        }

        return (new \LaravelFlare\Flare\Admin\Attributes\BaseAttribute($attribute, $field))->renderAdd();  
    }

    /**
     * Returns the Edit Attribute Rendered View.
     * 
     * Attributes should really be registered in an AttributeServiceProvider and/or
     * the Flare Configuration file, so that they can be expanded on, overridden etc.
     * 
     * @param  string $attribute   
     * @param  string $field 
     * @param  string $model 
     * 
     * @return        
     */
    public function editAttribute($attribute, $field, $model)
    {
        if (isset($field['type']) && $this->attributeTypeExists($field['type'])) {
            $fieldType = '\LaravelFlare\Flare\Admin\Attributes\\' . $field['type'] . 'Attribute';

            return (new $fieldType($attribute, $field, $model))->renderEdit();
        }

        return (new \LaravelFlare\Flare\Admin\Attributes\BaseAttribute($attribute, $field, $model))->renderEdit();
    }

    /**
     * Returns the View Attribute Rendered View.
     * 
     * Attributes should really be registered in an AttributeServiceProvider and/or
     * the Flare Configuration file, so that they can be expanded on, overridden etc.
     * 
     * @param  string $attribute   
     * @param  string $field 
     * @param  string $model 
     * 
     * @return        
     */
    public function viewAttribute($attribute, $field, $model)
    {
        if (isset($field['type']) && $this->attributeTypeExists($field['type'])) {
            $fieldType = '\LaravelFlare\Flare\Admin\Attributes\\' . $field['type'] . 'Attribute';

            return (new $fieldType($attribute, $field, $model))->renderView();
        }

        return (new \LaravelFlare\Flare\Admin\Attributes\BaseAttribute($attribute, $field, $model))->renderView();
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
