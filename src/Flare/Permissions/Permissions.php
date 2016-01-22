<?php

namespace LaravelFlare\Flare\Permissions;

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

        $reflection = new \ReflectionClass(new $class());
        
        if (!$reflection->implementsInterface(\LaravelFlare\Flare\Contracts\Permissions\Permissionable::class)) {
            return true;
        }

        if (\Auth::user()->can($action, $class)) {
            return true;
        }

        return false;
    }
}
