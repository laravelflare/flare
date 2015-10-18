<?php

namespace LaravelFlare\Flare\Contracts;

interface PermissionsInterface
{
    /**
     * Permissions check
     *
     * @param string $class
     * 
     * @return 
     */
    public static function check($class);
}
