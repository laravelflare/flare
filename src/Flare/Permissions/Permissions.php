<?php

namespace LaravelFlare\Flare\Permissions;

use LaravelFlare\Flare\Contracts\Permissionable;

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
    public static function check($class, $action = 'view')
    {
        if (\Auth::user()->can($action, $class)) {
            return true;
        }

        return false;
    }
}
