<?php

namespace LaravelFlare\Flare;

use Blade;
use LaravelFlare\Flare\Flare;
use Illuminate\Support\ServiceProvider;

class FlareServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     */
    public function boot(\Illuminate\Routing\Router $router)
    {
        // Assets
        $this->publishes([
            __DIR__.'/../public/' => public_path('vendor/flare'),
            __DIR__.'/../../vendor/twbs/bootstrap/dist' => public_path('vendor/bootstrap'),
        ], 'public');

        // Config - I would prefer to call this something self-descriptive, such as 'admin.php'
        $this->publishes([
            __DIR__.'/../config/flare.php' => config_path('flare.php'),
        ]);

        // Middleware
        $router->middleware('flareauthenticate', 'LaravelFlare\Flare\Http\Middleware\FlareAuthenticate');
        $router->middleware('checkpermissions', 'LaravelFlare\Flare\Http\Middleware\CheckPermissions');

        // Routes
        if (!$this->app->routesAreCached()) {
            require __DIR__.'/Http/routes.php';
        }

        // Views
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'flare');
        $this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/flare'),
        ]);

        $this->registerBladeOperators();
    }

    /**
     * Register any package services.
     */
    public function register()
    {
        // Merge Config 
        $this->mergeConfigFrom(
            __DIR__.'/../config/flare.php', 'flare'
        );
        
        $this->registerServiceProviders();

        $this->app->singleton('flare', function ($app) {
            return new Flare($app);
        });

        $loader = \Illuminate\Foundation\AliasLoader::getInstance();
        $loader->alias('Flare', \LaravelFlare\Flare\Facades\Flare::class);
    }

    /**
     * Register Service Providers
     */
    public function registerServiceProviders()
    {
        \App::register('LaravelFlare\Flare\Providers\ArtisanServiceProvider');
    }

    /**
     * Register Blade Operators.
     */
    public function registerBladeOperators()
    {
        // get blade compiler
        /*$blade = $this->app['view']->getEngineResolver()->resolve('blade')->getCompiler();

        $blade->extend(function($view, $compiler)
        {
             return preg_replace('/@get(/', '<?php var_dump($view); var_dump($compiler); ?>', $view);
            var_dump($view);
            echo '<br><br>';
            var_dump($compiler);
        });*/

        //var_dump($blade); die();

        // Blade Operator @get() for returning DotNotation Variables
        //Blade::directive('get', function ($expression) {


        /*    return "<?php echo $expression; ?>";
        //});*/

        // I'd prefer the possibility of providing this default functionality:
        // 
        // <code>
        //  @get($key) where $key = 'model.group.name'
        // </code>
        // 
        // With this added extra level of flexibility for a clean notation:
        // 
        // <code>
        //  @get($model, $key) where $key = 'group.name'
        // </code>
        // 
        // Which allows:
        // 
        // <code>
        // @get('model.group.name')
        // </code>
        // 
        // And this, respectively:
        // 
        // <code>
        //  @get($model, 'group.name')
        // </code>
        // 
    }
}
