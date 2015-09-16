<?php

namespace Flare\Permissions;

class Permissions
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
