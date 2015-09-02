<?php

namespace JacobBaileyLtd\Flare\Admin;

use Symfony\Component\Finder\Finder;
use Illuminate\Support\Collection;

class ModelAdminCollection extends Collection
{
    /**
     * The items contained in the collection.
     *
     * @var array
     */
    protected $items = [];

    /**
     * __construct
     */
    public function __construct()
    {
        $this->items = $this->getModelAdminClasses();
    }

    /**
     * Note: I don't think this will load SubClasses of ModelAdmin children? 
     *       The question is, do we want it to? 
     * 
     * Gets ModelAdmin classes based on the current users permissions
     * which have been set. If a ModelAdmin class has not had the
     * Permissions provided, it will be displayed by default.
     * 
     * @return 
     */
    public function getModelAdminClasses()
    {
        $classCollection = [];

        foreach (config('flare.models') as $class) {
            if (! $this->usableClass($class)) continue;
            $classCollection[] = $class;
        }

        return $classCollection;
    }

    /**
     * Register ModelAdmin Routes
     * 
     * @return
     */
    public function registerRoutes()
    {
        foreach ($this->items as $class) {
            (new $class)->registerRoutes();
        }
    }

    /**
     * Determines if a class is usable by the currently
     * defined user and their permission set.
     * 
     * @param  string $class 
     * 
     * @return
     */
    private function usableClass($class)
    {
        // Should replace this with ReflectionClass::getShortName();
        if ($class == 'JacobBaileyLtd\Flare\Admin\ModelAdmin') return false;
        
        if (!$this->checkModelAdminPermissions($class)){
            return false;
        }

        return true;
    }

    /**
     * Checks whether a ModelAdminPermissions are set if they are
     * it will check validity for the current user otherwise
     * it will return true, since all users have access
     * to this model admin.
     * 
     * @param  string $class 
     * 
     * @return        
     */
    private function checkModelAdminPermissions($class)
    {
        if (!is_subclass_of($class, \JacobBaileyLtd\Flare\Contracts\PermissionsContract::class)) {
            return true;
        }

        return $this->checkUserHasModelAdminPermissions($class);
    }

    /**
     * Checks if the current user has access to a given 
     * ModelAdmin class and returns a boolean.
     * 
     * @param  $class
     * 
     * @return         
     */
    private function checkUserHasModelAdminPermissions($class)
    {
        // Replace this with actual Permission Implementation Check
        return true;
    }

    /**
     * Finds all 
     * @return [type] [description]
     */
    public static function findClasses()
    {
        /*$finder = new Finder();
        $finder->files()->name('*.php')->in(base_path());

        foreach ($finder as $file) {
            $ns = $namespace;
            if ($relativePath = $file->getRelativePath()) {
                $ns .= '\\'.strtr($relativePath, '/', '\\');
            }
            $class = $ns.'\\'.$file->getBasename('.php');

            $r = new \ReflectionClass($class);
        }*/
    }

    /**
     * NOTE: This should be moved to a more appropriate class
     * 
     * @param string $parent 
     * 
     * @return
     */
    private static function getSubClassesOf($parent)
    {
        $subClasses = [];

        foreach (get_declared_classes() as $class) {
            if (is_subclass_of($class, $parent)) {
                $result[] = $class;
            }
        }

        return $subClasses;
    }
}