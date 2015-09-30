<?php

namespace LaravelFlare\Flare\Permissions;

use LaravelFlare\Flare\Contracts\PermissionsInterface;

class Permissions implements PermissionsInterface
{
    public function __construct()
    {
    }

    /**
     * Checks if the currently Authenticated User
     * has access to a given ModelAdmin etc.
     * 
     * @return
     */
    public static function check()
    {
        return true;
    }
}
