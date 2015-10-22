<?php

namespace LaravelFlare\Flare\Contracts\Permissions;

interface PermissionsInterface
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
