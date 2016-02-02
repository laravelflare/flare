<?php

namespace LaravelFlare\Flare;

use Illuminate\Routing\Router;
use LaravelFlare\Flare\Admin\Attributes\BaseAttribute;

class Flare
{
    /**
     * The Flare version.
     *
     * @var string
     */
    const VERSION = '0.9.x-dev';

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
        'core_notifications' => true,
    ];

    /**
     * The Title of the Admin Panel
     * 
     * @var string
     */
    protected $adminTitle;

    /**
     * Safe Title of the Admin Panel
     * 
     * @var string
     */
    protected $safeAdminTitle;

    /**
     * Relative Base URL of Admin Panel
     * 
     * @var string
     */
    protected $relativeAdminUrl;

    /**
     * __construct.
     */
    public function __construct(Router $router)
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
            return config('flare.config.'.$key, $this->configurationKeys[$key]);
        }

        return config('flare.'.$key);
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
     * Sets the Admin Title
     * 
     * @param mixed $title
     *
     * @return void
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
     * 
     * @return void
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
        return url($this->getRelativeAdminUrl($path));
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
            throw new \Exception('Attribute Field Type cannot be empty or undefined.');
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
