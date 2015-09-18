<?php

namespace LaravelFlare\Flare\Admin;

use Illuminate\Support\Str;

abstract class Admin
{
    
    /**
     * Admin Section Icon
     *
     * Font Awesome Defined Icon, eg 'user' = 'fa-user'
     *
     * @var string
     */
    public static $icon;

    /**
     * Title of Model Admin.
     *
     * @var string
     */
    protected $title = null;

    /**
     * Title of Model Admin.
     *
     * @var string
     */
    protected $pluralTitle = null;

    /**
     * URL Prefix Model Admin.
     *
     * @var string
     */
    protected $urlPrefix = null;

    /**
     * The Controller to be used by the Model Admin
     *
     * This defaults to parent::getController()
     * if it has been left undefined. 
     * 
     * @var string
     */
    protected $controller = '\LaravelFlare\Flare\Http\Controllers\AdminController';

    /**
     * Class Prefix used for matching and removing term
     * from user provided Admin sections
     *
     * @var string
     */
    const CLASS_PREFIX = '';

    /**
     * __construct.
     */
    public function __construct()
    {

    }

    /**
     * Register the routes for this Admin Section.
     *
     * Default routes include, create:, read:, update:, delete:
     *
     * Also attempts to load in ModelAdminController
     * based on the ShortName of the class, for
     * overloading and adding additional routes
     * 
     * @return
     */
    public function registerRoutes()
    {
        // We will need to throw an exception if a ModelAdmin manages a Model which conflicts with an internal flare endpoint
        // such as (create, edit, view, delete etc) 
        \Route::group(['prefix' => static::UrlPrefix(), 'namespace' => get_called_class(), 'as' => static::UrlPrefix()], function () {
            $this->registerSubRoutes();
            \Route::controller('/', $this->getController());
        });
    }

    /**
     * Register subRoutes for this Admin Section
     *
     * @return
     */
    public function registerSubRoutes()
    {
        
    }

    /**
     * Returns the Controller Class for the current Admin section
     * 
     * @return string
     */
    public function getController()
    {
        return $this->controller;
    }

    /**
     * ShortName of a ModelAdmin Class.
     *
     * @return string
     */
    public static function ShortName()
    {
        return (new \ReflectionClass(new static()))->getShortName();
    }

    /**
     * Title of a ModelAdmin Class.
     *
     * @return string
     */
    public static function Title()
    {
        if (!isset(static::$title) || !static::$title) {
            return Str::title(str_replace('_', ' ', snake_case(str_replace(static::CLASS_PREFIX, '',  static::ShortName()))));
        }

        return static::$title;
    }

    /**
     * Plural of the ModelAdmin Class Title.
     *
     * @return string
     */
    public static function PluralTitle()
    {
        if (!isset(static::$pluralTitle) || !static::$pluralTitle) {
            return Str::plural(str_replace(' '.static::CLASS_PREFIX, '',  static::Title()));
        }

        return static::$pluralTitle;
    }

    /**
     * URL Prefix to a ModelAdmin Top Level Page.
     *
     * @return string
     */
    public static function UrlPrefix()
    {
        if (!isset(static::$urlPrefix) || !static::$urlPrefix) {
            return str_replace(' ', '', strtolower(str_replace(static::CLASS_PREFIX, '',  static::PluralTitle())));
        }

        return static::$urlPrefix;
    }

    /**
     * URL to a ModelAdmin Top Level Page.
     *
     * @return string
     */
    public static function Url()
    {
        // Update 'admin' to use Admin config variable
        return url('admin/'.static::UrlPrefix());
    }

    /**
     * Relative URL to a ModelAdmin Top Level Page.
     *
     * @return string
     */
    public static function RelativeUrl()
    {
        // Update 'admin' to use Admin config variable
        return 'admin/'.static::UrlPrefix();
    }

    /**
     * Retrieves the Current ModelAdmin Route URL.
     *
     * @return string
     */
    public static function CurrentUrl()
    {
        return url(static::RelativeCurrentUrl());
    }

    /**
     * Retrieves the Current ModelAdmin Route URL.
     *
     * @return string
     */
    public static function RelativeCurrentUrl()
    {
        return \Route::current()->getPrefix();
    }

    /**
     * Handle dynamic static method calls into the ModelAdmin.
     *
     * @param string $method
     * @param array  $parameters
     * 
     * @return mixed
     */
    public static function __callStatic($method, $parameters)
    {
        $instance = new static();

        return call_user_func_array([$instance, $method], $parameters);
    }
}
