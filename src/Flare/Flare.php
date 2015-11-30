<?php

namespace LaravelFlare\Flare;

use LaravelFlare\Flare\Admin\Attributes\BaseAttribute;

class Flare
{
    /**
     * The Flare version.
     *
     * @var string
     */
    const VERSION = '0.3.x-dev';

    /**
     * Array of expected configuration keys
     * with the absolute bare-minimum defaults.
     * 
     * @var array
     */
    protected $configurationKeys = [
        'admin_title' => 'Laravel <b>Flare</b>',
        'admin_url' => 'admin',
        'admin_theme' => 'red',
        'admin' => [],
        'attributes' => [],
        'models' => [],
        'modules' => [],
        'widgets' => [],
        'permissions' => \LaravelFlare\Flare\Permissions\Permissions::class,
        'policies' => [],
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
     * Returns the defined Admin Title.
     * 
     * @return string
     */
    public function adminTitle()
    {
        return \Flare::config('admin_title');
    }

    /**
     * Returns the defined Admin Title, converted
     * to a safer format (for <title> tags etc.).
     * 
     * @return string
     */
    public function safeAdminTitle()
    {
        return strip_tags(\Flare::config('admin_title'));
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
     * Returns an array of all of the Available Attribute Types.
     * 
     * @return array
     */
    protected function availableAttributes()
    {
        $availableAttributes = [];

        foreach (\Flare::config('attributes') as $attributeFullClassname) {
            $availableAttributes = array_add(
                                            $availableAttributes,
                                            class_basename($attributeFullClassname),
                                            $attributeFullClassname
                                        );
        }

        return $availableAttributes;
    }

    /**
     * Determines if an AttributeType class exists or not.
     * 
     * @param string $type
     * 
     * @return bool
     */
    protected function attributeTypeExists($type)
    {
        return $this->resolveAttributeClass($type) ? true : false;
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
        if (!isset($field['type'])) {
            throw new Exception('Attribute Field Type cannot be empty or undefined.');
        }

        if ($this->attributeTypeExists($field['type'])) {
            $fieldType = $this->resolveAttributeClass($field['type']);

            return call_user_func_array([new $fieldType($attribute, $field, $model, $modelManager), camel_case('render_'.$action)], []);
        }

        return call_user_func_array([new BaseAttribute($attribute, $field, $model, $modelManager), camel_case('render_'.$action)], []);
    }

    /**
     * Resolves the Class of an Attribute and returns it as a string.
     * 
     * @param string $type
     * 
     * @return string
     */
    protected function resolveAttributeClass($type)
    {
        $fullClassname = array_key_exists(title_case($type).'Attribute', $this->availableAttributes()) ? $this->availableAttributes()[title_case($type).'Attribute'] : false;

        if (!$fullClassname || !class_exists($fullClassname)) {
            return false;
        }

        return $fullClassname;
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
