<?php

namespace LaravelFlare\Flare\Providers;

use Illuminate\Routing\Router;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
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
     * Define your route model bindings, pattern filters, etc.
     *
     * @param \Illuminate\Routing\Router $router
     */
    public function boot(Router $router)
    {
        //

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
     * @param  Router $router
     * 
     * @return void
     */
    protected function registerMiddleware(Router $router)
    {
        $router->middleware('flareauthenticate', \LaravelFlare\Flare\Http\Middleware\FlareAuthenticate::class);
        $router->middleware('checkmodelfound', \LaravelFlare\Flare\Http\Middleware\CheckModelFound::class);
        $router->middleware('checkpermissions', \LaravelFlare\Flare\Http\Middleware\CheckPermissions::class);

        $router->middlewareGroup('flarebase', [
                \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
                \Illuminate\Session\Middleware\StartSession::class,
                \Illuminate\View\Middleware\ShareErrorsFromSession::class,
                \App\Http\Middleware\VerifyCsrfToken::class,
                \App\Http\Middleware\EncryptCookies::class,
            ]);

        $router->middlewareGroup('flare', [
                'flarebase',
                'flareauthenticate',
                'checkpermissions',
            ]);
    }

    /**
     * Register the Defined Routes.
     *
     * This registers all the routes which have been defined by
     * Admin sections defined in the Application's Flare Config
     * (or in the runtime config if anotehr service provider
     * has already started manipulating these dynamically).
     * 
     * @param  Router $router 
     * 
     * @return void
     */
    protected function registerDefinedRoutes(Router $router)
    {
        $router->group(
            [
                'prefix' => \Flare::config('admin_url'),
                'as' => 'flare::',
                'middleware' => ['flare']
            ], 
            function ($router) {
                \Flare::admin()->registerRoutes($router);
                $router->get('/', $this->namespace.'\AdminController@getDashboard')->name('dashboard');
            }
        );
    }

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
     * @param  Router $router 
     * 
     * @return void
     */
    protected function registerDefaultRoutes(Router $router)
    {
        $router->group(
            [
                'prefix' => \Flare::config('admin_url'),
                'as' => 'flare::',
                'middleware' => ['flarebase']
            ], 
            function ($router) {
                $router->get('index', $this->namespace.'\AdminController@getIndex')->name('index');

                if (\Flare::show('login')) {
                    $router->get('login', $this->namespace.'\AdminController@getLogin')->name('login');
                    $router->post('login', $this->namespace.'\AdminController@postLogin')->name('login');
                } 

                $router->get('logout', $this->namespace.'\AdminController@getLogout')->name('logout');
                $router->get('reset', $this->namespace.'\AdminController@getReset')->name('reset');
            }
        );
    }
}
