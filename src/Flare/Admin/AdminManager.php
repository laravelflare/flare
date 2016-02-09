<?php

namespace LaravelFlare\Flare\Admin;

use Illuminate\Routing\Router;
use LaravelFlare\Flare\Permissions\Permissions;

class AdminManager
{
    /**
     * Base Class.
     *
     * The Base Class for Model Admin's
     */
    const BASE_CLASS = 'LaravelFlare\Flare\Admin\Admin';

    /**
     * Admin Config Key.
     *
     * Key which defined where in the Flare Admin Config to
     * load the Admin classes from.
     *
     * @var string
     */
    const ADMIN_KEY = 'admin';

    /**
     * __construct.
     */
    public function __construct()
    {
    }

    /**
     * Returns the array used for the Admin Menu.
     *
     * This is temporary but it shouldn't be a breaking
     * change when it is altered or removed.
     * 
     * @return 
     */
    public function getAdminMenu()
    {
        return $this->getAdminClasses();
    }

    /**
     * Gets Admin classes based on the current users permissions
     * which have been set. If a Admin class has not had the
     * Permissions provided, it will be displayed by default.
     * 
     * @return 
     */
    public function getAdminClasses()
    {
        $classCollection = [];

        if (!defined('static::ADMIN_KEY')) {
            return $classCollection;
        }

        $classCollection = $this->getSubAdminClasses(\Flare::config(static::ADMIN_KEY));

        return $classCollection;
    }

    /**
     * Takes an array of classes and returns the 
     * classes which are available with the 
     * current permissions/policy set.
     * 
     * @param array $classes
     * 
     * @return array
     */
    public function getSubAdminClasses(array $classes)
    {
        $classCollection = [];

        foreach ($classes as $key => $class) {
            if ($this->usableClass($key)) {
                $classCollection[] = [$key => $this->getSubAdminClasses($class)];
                continue;
            }

            if ($this->usableClass($class)) {
                $classCollection[] = $class;
                continue;
            }
        }

        return $classCollection;
    }

    /**
     * Returns an instance of the Admin.
     * 
     * @return Admin
     */
    public static function getAdminInstance()
    {
        if (!$requested = Admin::getRequested()) {
            return;
        }

        return new $requested();
    }

    /**
     * Register Admin Routes.
     *
     * Loops through all of the Admin classes in the collection
     * and registers their Admin Routes.
     */
    public function registerRoutes(Router $router)
    {
        $this->registerSubRoutes($this->getAdminClasses());
    }

    /**
     * Loops through an array of classes
     * and registers their Route recursively.
     * 
     * @param array $classes
     */
    public function registerSubRoutes(array $classes)
    {
        foreach ($classes as $key => $class) {
            if (is_array($class)) {
                if ($this->usableClass($key)) {
                    $this->registerRoute($key);
                }

                $this->registerSubRoutes($class);
                continue;
            }
            $this->registerRoute($class);
        }
    }

    /**
     * Registers an individual group of Admin routes.
     * 
     * @param string $class
     */
    public function registerRoute($class)
    {
        (new $class())->registerRoutes(\App::make(\Illuminate\Routing\Router::class));
    }

    /**
     * Determines if a class is usable by the currently
     * defined user and their permission set.
     * 
     * @param string $class
     * 
     * @return bool
     */
    private function usableClass($class)
    {
        if (!is_scalar($class) || !class_exists($class)) {
            return false;
        }

        if ($class == static::BASE_CLASS) {
            return false;
        }

        return true;
    }
}
