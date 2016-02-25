<?php

namespace LaravelFlare\Flare\Providers;

use Illuminate\Routing\Router;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

abstract class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to the controller routes in your routes file.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = '\LaravelFlare\Flare\Http\Controllers';
    
    /**
     * The compatibility version of this RouteServiceProvider
     * 
     * @var string
     */
    protected $compatibilityVersion;

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @param \Illuminate\Routing\Router $router
     */
    public function boot(Router $router)
    {
        parent::boot($router);
    }

    /**
     * Define the routes for the application.
     *
     * @param \Illuminate\Routing\Router $router
     */
    public function map(Router $router)
    {
        $this->registerMiddleware($router);
        $this->registerDefinedRoutes($router);
        $this->registerDefaultRoutes($router);
    }

    /**
     * Register all the Flare Provided Middleware and Middleware Groups.
     *
     * We define flarebase rather than extend an existing middleware stack
     * since it is possible that a user has amended the default middleware 
     * of their application in a way that could break Flare.
     * 
     * @param Router $router
     */
    abstract protected function registerMiddleware(Router $router);

    /**
     * Register the Defined Routes.
     *
     * This registers all the routes which have been defined by
     * Admin sections defined in the Application's Flare Config
     * (or in the runtime config if anotehr service provider
     * has already started manipulating these dynamically).
     * 
     * @param Router $router
     */
    abstract protected function registerDefinedRoutes(Router $router);

    /**
     * Register the Default Routes.
     *
     * This registers all the default routes which are included
     * with Flare. These consist of things which will probably
     * be included with every application such as the login,
     * logout and password reset forms.
     *
     * The login form can however be hidden by setting the 
     * 'show' config for 'login' to false.
     * 
     * @param Router $router
     */
    abstract protected function registerDefaultRoutes(Router $router);

    /**
     * Return the Controller or Controller and Route if provided.
     * 
     * @param  string $route 
     * 
     * @return string
     */
    protected function adminController($route = null)
    {
        if ($route) {
            return $this->namespace.'\\'.$this->compatibilityVersion.'\AdminController@'.$route;
        }

        return $this->namespace.'\\'.$this->compatibilityVersion.'\AdminController';
    }
}
