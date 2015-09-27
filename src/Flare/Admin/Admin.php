<?php

namespace LaravelFlare\Flare\Admin;

use Illuminate\Support\Str;

abstract class Admin
{
    /**
     * Admin Section Icon.
     *
     * Font Awesome Defined Icon, eg 'user' = 'fa-user'
     *
     * @var string
     */
    public static $icon;

    /**
     * Title of Admin Section.
     *
     * @var string
     */
    protected $title = null;

    /**
     * Plural Title of Admin Section.
     *
     * @var string
     */
    protected $pluralTitle = null;

    /**
     * URL Prefix of Admin Section.
     *
     * @var string
     */
    protected $urlPrefix = null;

    /**
     * The Controller to be used by the Admin.
     *
     * This defaults to parent::getController()
     * if it has been left undefined. 
     * 
     * @var string
     */
    protected $controller = \LaravelFlare\Flare\Http\Controllers\AdminController::class;

    /**
     * The Admin Default View.
     *
     * By Default this is the 404 page
     *
     * @var string
     */
    protected static $view = 'admin.404';

    /**
     * Class Prefix used for matching and removing term
     * from user provided Admin sections.
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
     * based on the shortName of the class, for
     * overloading and adding additional routes
     * 
     * @return
     */
    public function registerRoutes()
    {
        // We will need to throw an exception if a ModelAdmin manages a Model which conflicts with an internal flare endpoint
        // such as (create, edit, view, delete etc) 
        \Route::group(['prefix' => static::urlPrefix(), 'namespace' => get_called_class(), 'as' => static::urlPrefix()], function() {
            $this->registerSubRoutes();
            \Route::controller('/', $this->getController());
        });
    }

    /**
     * Register subRoutes for this Admin Section.
     *
     * @return
     */
    public function registerSubRoutes()
    {
    }

    /**
     * Returns the Requested Namespace as a string.
     * 
     * @return string|void
     */
    public function getRequestedNamespace()
    {
        if (!\Route::current()) {
            return;
        }

        $currentAction = \Route::current()->getAction();

        if (isset($currentAction['namespace'])) {
            return $currentAction['namespace'];
        }

        return;
    }

    /**
     * Returns the Controller Class for the current Admin section.
     * 
     * @return string
     */
    public function getController()
    {
        return $this->controller;
    }

    /**
     * Returns the Module Admin View.
     * 
     * @return string
     */
    public function getView()
    {
        if (view()->exists(static::$view)) {
            return static::$view;
        }

        return 'flare::'.static::$view;
    }

    public function getViewData()
    {
        return [];
    }

    /**
     * shortName of a Admin Section Class.
     *
     * @return string
     */
    public static function shortName()
    {
        return (new \ReflectionClass(new static()))->getshortName();
    }

    /**
     * Title of a Admin Section Class.
     *
     * @return string
     */
    public static function title()
    {
        if (!isset(static::$title) || !static::$title) {
            return Str::title(str_replace('_', ' ', snake_case(str_replace(static::CLASS_PREFIX, '', static::shortName()))));
        }

        return static::$title;
    }

    /**
     * Plural of the Admin Section Class Title.
     *
     * @return string
     */
    public static function pluralTitle()
    {
        if (!isset(static::$pluralTitle) || !static::$pluralTitle) {
            return Str::plural(str_replace(' '.static::CLASS_PREFIX, '', static::title()));
        }

        return static::$pluralTitle;
    }

    /**
     * URL Prefix to a Admin Section Top Level Page.
     *
     * @return string
     */
    public static function urlPrefix()
    {
        if (!isset(static::$urlPrefix) || !static::$urlPrefix) {
            return str_replace(' ', '', strtolower(str_replace(static::CLASS_PREFIX, '', static::pluralTitle())));
        }

        return static::$urlPrefix;
    }

    /**
     * URL to a Admin Top Level Page.
     *
     * @return string
     */
    public static function url($path = '')
    {
        return url(self::relativeUrl($path));
    }

    /**
     * Relative URL to an Admin Top Level Page.
     *
     * @return string
     */
    public static function relativeUrl($path = '')
    {
        return \Flare::relativeAdminurl(static::urlPrefix().($path ? '/'.$path : ''));
    }

    /**
     * Retrieves the Current Admin Route URL.
     *
     * @return string
     */
    public static function currentUrl($path = '')
    {
        return url(static::relativeCurrentUrl($path));
    }

    /**
     * Retrieves the Current Admin Route URL.
     *
     * @return string
     */
    public static function relativeCurrentUrl($path)
    {
        return \Route::current()->getPrefix().'/'.$path;
    }

    /**
     * Handle dynamic static method calls into the Admin.
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
