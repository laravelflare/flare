<?php

namespace LaravelFlare\Flare\Permissions;

use LaravelFlare\Flare\Exceptions\PermissionsException;
use LaravelFlare\Flare\Contracts\Permissions\Permissionable;

class Permissions implements Permissionable
{
    /**
     * Checks if the currently Authenticated User
     * has access to a given action.
     *
     * @param string $class
     * @param string $action
     * 
     * @return
     */
    public static function check($class = null, $action = 'view')
    {
        if (!$class) {
            return \Auth::user()->is_admin;
        }

        if ((new \ReflectionClass(new $class()))->implementsInterface(\LaravelFlare\Flare\Contracts\Permissions\Permissionable::class)) {
            return \Auth::user()->can($action, $class);
        }

        return \Auth::user()->is_admin;
    }

    /**
     * Method called when a User attempts to access
     * an area of the site or admin which they do 
     * not have the permissions to interact with.
     *
     * This is typically called from the CheckPermissions
     * Middleware during a request (see: \LaravelFlare\Flare\Http\Middleware\CheckPermissions::handle())
     * and can be used to throw an exception, return a 
     * view (abort() etc.) or anything else really.
     * 
     * @param  string $class 
     * @param  string $action
     *
     * @return mixed
     */
    public static function denied($class = null, $action = 'view')
    {
        throw new PermissionsException('Permission denied!');
    }
}
