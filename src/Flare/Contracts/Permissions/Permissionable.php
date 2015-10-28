<?php

namespace LaravelFlare\Flare\Contracts\Permissions;

interface Permissionsable
{
    /**
     * Permissions check.
     *
     * @param string $class
     * @param string $action
     * 
     * @return 
     */
    public static function check($class, $action = 'view');
}
