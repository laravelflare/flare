<?php

namespace LaravelFlare\Flare\Admin;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Routing\Router;
use LaravelFlare\Flare\Support\ControllerInspector;

abstract class Admin
{
    /**
     * Admin Section Icon.
     *
     * Font Awesome Defined Icon, eg 'user' = 'fa-user'
     *
     * @var string
     */
    protected $icon;

    /**
     * Title of Admin Section.
     *
     * @var string
     */
    protected $title;

    /**
     * Plural Title of Admin Section.
     *
     * @var string
     */
    protected $pluralTitle;

    /**
     * URL Prefix of Admin Section.
     *
     * @var string
     */
    protected $urlPrefix;

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
     * The Policy used for the Admin Authorization logic.
     * 
     * @var string
     */
    protected $policy = '\LaravelFlare\Flare\Permissions\AdminPolicy';

    /**
     * An array of subclasses of Admin
     * which allows hierachy in a Module.
     * 
     * @var array
     */
    protected $subAdmin = [];

    /**
     * The Admin Default View.
     *
     * By Default this is the 404 page
     *
     * @var string
     */
    protected $view = 'admin.404';

    /**
     * Array of View Data to Render.
     * 
     * @var array
     */
    protected $viewData = [];

    /**
     * Class Suffix used for matching and removing term
     * from user provided Admin sections.
     *
     * @var string
     */
    const CLASS_SUFFIX = 'Admin';

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
     * @param \Illuminate\Routing\Router $router
     */
    public function registerRoutes(Router $router)
    {
        // We will need to throw an exception if a ModelAdmin manages a Model which conflicts with an internal flare endpoint
        // such as (create, edit, view, delete etc) 
        $router->group(['prefix' => $this->urlPrefix(), 'namespace' => get_called_class(), 'as' => $this->urlPrefix()], function ($router) {
            $this->registerSubRoutes();
            $this->registerController($this->getController());
        });
    }

    /**
     * Register subRoutes for Defined Admin instances.
     *
     * @return
     */
    public function registerSubRoutes()
    {
        if (!is_array($this->subAdmin)) {
            return;
        }

        foreach ($this->subAdmin as $adminItem) {
            $this->registerRoute($adminItem->getController(), $adminItem->routeParameters());
        }
    }

    /**
     * Register an individual route.
     *
     * @param string $controller
     * @param array  $parameters
     *
     * @return
     */
    public static function registerRoute($controller, $parameters = [])
    {
        \Route::group($parameters, function ($controller) {
            \Route::registerController($controller);
        });
    }

    /**
     * Stolen Method from 5.2 Illumiante/Routing/Router.
     * 
     * @param  string $controller 
     * @return void          
     */
    public static function registerController($controller)
    {
        $uri = '/';

        $routable = (new ControllerInspector)
                            ->getRoutable($controller, $uri);

        // When a controller is routed using this method, we use Reflection to parse
        // out all of the routable methods for the controller, then register each
        // route explicitly for the developers, so reverse routing is possible.
        foreach ($routable as $method => $routes) {
            foreach ($routes as $route) {
                $action = ['uses' => $controller.'@'.$method];

                \Route::{$route['verb']}($route['uri'], $action);
            }
        }

        \Route::any($uri.'/{_missing}', $controller.'@missingMethod');
    }

    /**
     * Returns the Route Paramets.
     * 
     * @return array
     */
    public function routeParameters()
    {
        return [
            'prefix' => $this->urlPrefix(),
            'as' => $this->urlPrefix(),
        ];
    }

    /**
     * Returns the Requested Route Action as a
     * string, namespace is returned by default.
     *
     * @param string $key
     * 
     * @return string|void
     */
    public static function getRequested($key = 'namespace')
    {
        if (!\Route::current()) {
            return;
        }

        $currentAction = \Route::current()->getAction();

        if (isset($currentAction[$key])) {
            return $currentAction[$key];
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
     * Set the Controller Class for the current Admin section.
     * 
     * @return string
     */
    public function setController($controller = null)
    {
        $this->controller = $controller;
    }

    /**
     * Returns the Module Admin View.
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
     * Set the Module Admin View.
     * 
     * @param string $view
     */
    public function setView($view = null)
    {
        $this->view = $view;
    }

    /**
     * Returns the View Data.
     * 
     * @return array
     */
    public function getViewData()
    {
        return $this->viewData;
    }

    /**
     * Set the View Data.
     * 
     * @param array $viewData
     */
    public function setViewData($viewData = [])
    {
        $this->viewData = $viewData;
    }

    /**
     * Menu Items.
     * 
     * @return array
     */
    public function menuItems()
    {
        return [];
    }

    /**
     * Icon of a Admin Section Class.
     *
     * @return string
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * Set Icon of a Admin Section Class.
     *
     * @param string $icon
     */
    public function setIcon($icon = null)
    {
        $this->icon = $icon;
    }

    /**
     * Shortname of a Admin Section Class.
     *
     * @return string
     */
    public static function shortName()
    {
        return (new \ReflectionClass(new static()))->getShortName();
    }

    /**
     * Title of a Admin Section Class.
     *
     * @return string
     */
    public function getTitle()
    {
        if (!isset($this->title) || !$this->title) {
            return Str::title(str_replace('_', ' ', snake_case(preg_replace('/'.static::CLASS_SUFFIX.'$/', '', static::shortName()))));
        }

        return $this->title;
    }

    /**
     * Set Title of a Admin Section Class.
     *
     * @param string $title
     */
    public function setTitle($title = null)
    {
        $this->title = $title;
    }

    /**
     * Plural of the Admin Section Class Title.
     *
     * @return string
     */
    public function getPluralTitle()
    {
        if (!isset($this->pluralTitle) || !$this->pluralTitle) {
            return Str::plural($this->getTitle());
        }

        return $this->pluralTitle;
    }

    /**
     * Set Plural Title.
     * 
     * @param string $pluralTitle
     */
    public function setPluralTitle($pluralTitle = null)
    {
        $this->pluralTitle = $pluralTitle;
    }

    /**
     * URL Prefix to a Admin Section Top Level Page.
     *
     * @return string
     */
    public function urlPrefix()
    {
        if (!isset($this->urlPrefix) || !$this->urlPrefix) {
            return str_slug($this->getPluralTitle());
        }

        return $this->urlPrefix;
    }

    /**
     * URL to a Admin Top Level Page.
     *
     * @param string $path
     *
     * @return string
     */
    public function url($path = '')
    {
        return url($this->relativeUrl($path));
    }

    /**
     * Relative URL to an Admin Top Level Page.
     *
     * @param string $path
     *
     * @return string
     */
    public function relativeUrl($path = '')
    {
        return \Flare::relativeAdminUrl($this->urlPrefix().($path ? '/'.$path : ''));
    }

    /**
     * Retrieves the Current Admin Route URL.
     *
     * @param string $path
     *
     * @return string
     */
    public function currentUrl($path = '')
    {
        return url($this->relativeCurrentUrl($path));
    }

    /**
     * Retrieves the Current Admin Route URL.
     *
     * @param string $path
     *
     * @return string
     */
    public function relativeCurrentUrl($path)
    {
        return \Route::current() ? \Route::current()->getPrefix().'/'.$path : null;
    }

    /*
     * Handle dynamic static method calls into the Admin.
     *
     * @param string $method
     * @param array  $parameters
     * 
     * @return mixed
     */
    // public static function __callStatic($method, $parameters)
    // {
    //     $instance = new static();

    //     return call_user_func_array([$instance, $method], $parameters);
    // }
}
