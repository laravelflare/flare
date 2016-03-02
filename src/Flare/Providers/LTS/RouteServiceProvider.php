<?php

namespace LaravelFlare\Flare\Providers\LTS;

use Illuminate\Routing\Router;
use LaravelFlare\Flare\Providers\RouteServiceProvider as AbstractRouteServiceProvider;

class RouteServiceProvider extends AbstractRouteServiceProvider
{
    /**
     * The compatibility version of this RouteServiceProvider.
     * 
     * @var string
     */
    protected $compatibilityVersion = 'LTS';

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
                'middleware' => ['flareauthenticate', 'checkpermissions'],
            ],
            function ($router) {
                \Flare::admin()->registerRoutes($router);
                $router->get('/', $this->adminController('getDashboard'))->name('dashboard');
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
            ],
            function ($router) {
                // Logout route...
                $router->get('logout', $this->adminController('getLogout'))->name('logout');

                if (\Flare::show('login')) {
                    // Login request reoutes...
                    $router->get('login', $this->adminController('getLogin'))->name('login');
                    $router->post('login', $this->adminController('postLogin'))->name('login');

                    // Password reset link request routes...
                    $router->get('email', $this->adminController('getEmail'))->name('email');
                    $router->post('email', $this->adminController('postEmail'))->name('email');

                    // Password reset routes...
                    $router->get('reset/{token}', $this->adminController('getReset'))->name('reset');
                    $router->post('reset', $this->adminController('postReset'))->name('reset');
                }
            }
        );
    }
}
