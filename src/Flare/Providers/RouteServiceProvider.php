<?php

namespace LaravelFlare\Flare\Providers;

use Route;
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

        $router->group(['prefix' => \Flare::config('admin_url'), 'namespace' => $this->namespace, 'middleware' => ['flare']], function ($router) {
            (new \LaravelFlare\Flare\Admin\AdminManager())->registerRoutes();
        });

        $router->group(['prefix' => \Flare::config('admin_url'), 'middleware' => ['flarebase']], function ($router) {

            // Needs replacing with implicit routes, as controller is deprecated as of 5.2 and will be removed in 5.3
            $router->controller('/', $this->namespace . '\AdminController');

        });
    }
}
