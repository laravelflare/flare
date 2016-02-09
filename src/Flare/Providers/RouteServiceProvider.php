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
     * @param Router $router
     */
    protected function registerMiddleware(Router $router)
    {
        $router->middleware('flareauthenticate', \LaravelFlare\Flare\Http\Middleware\FlareAuthenticate::class);
        $router->middleware('checkmodelfound', \LaravelFlare\Flare\Http\Middleware\CheckModelFound::class);
        $router->middleware('checkpermissions', \LaravelFlare\Flare\Http\Middleware\CheckPermissions::class);

        $router->middlewareGroup('flarebase', [
                \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
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
     * @param Router $router
     */
    protected function registerDefinedRoutes(Router $router)
    {
        $router->group(
            [
                'prefix' => \Flare::config('admin_url'),
                'as' => 'flare::',
                'middleware' => ['flare'],
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
     * @param Router $router
     */
    protected function registerDefaultRoutes(Router $router)
    {
        $router->group(
            [
                'prefix' => \Flare::config('admin_url'),
                'as' => 'flare::',
                'middleware' => ['flarebase'],
            ],
            function ($router) {
                // Logout route...
                $router->get('logout', $this->namespace.'\AdminController@getLogout')->name('logout');

                if (\Flare::show('login')) {
                    // Login request reoutes...
                    $router->get('login', $this->namespace.'\AdminController@getLogin')->name('login');
                    $router->post('login', $this->namespace.'\AdminController@postLogin')->name('login');

                    // Password reset link request routes...
                    $router->get('email', $this->namespace.'\AdminController@getEmail')->name('email');
                    $router->post('email', $this->namespace.'\AdminController@postEmail')->name('email');

                    // Password reset routes...
                    $router->get('reset/{token}', $this->namespace.'\AdminController@getReset')->name('reset');
                    $router->post('reset', $this->namespace.'\AdminController@postReset')->name('reset');
                }
            }
        );
    }
}
