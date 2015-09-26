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
     * The Admin Default View
     *
     * By Default this is the 404 page
     *
     * @var string
     */
    protected $view = 'admin.404';

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
     * Returns the Module Admin View
     * 
     * @return string
     */
    public function getView()
    {
        if (view()->exists($this->view)) {
            return $this->view;
        }

        return 'flare::'.$this->view;
    }

    /**
     * ShortName of a Admin Section Class.
     *
     * @return string
     */
    public static function ShortName()
    {
        return (new \ReflectionClass(new static()))->getShortName();
    }

    /**
     * Title of a Admin Section Class.
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
     * Plural of the Admin Section Class Title.
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
     * URL Prefix to a Admin Section Top Level Page.
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
     * URL to a Admin Top Level Page.
     *
     * @return string
     */
    public static function Url($path = '')
    {
        return url(self::RelativeUrl($path));
    }

    /**
     * Relative URL to an Admin Top Level Page.
     *
     * @return string
     */
    public static function RelativeUrl($path = '')
    {
        return \Flare::relativeAdminUrl(static::UrlPrefix().($path ? '/'.$path : ''));
    }

    /**
     * Retrieves the Current Admin Route URL.
     *
     * @return string
     */
    public static function CurrentUrl($path = '')
    {
        return url(static::RelativeCurrentUrl($path));
    }

    /**
     * Retrieves the Current Admin Route URL.
     *
     * @return string
     */
    public static function RelativeCurrentUrl($path)
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
