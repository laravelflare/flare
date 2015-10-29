<?php

namespace LaravelFlare\Flare\Permissions;

use LaravelFlare\Flare\Contracts\ModelAdminPoliceable;

class AdminPolicy
{
    /**
     * Determine if the given Model can be viewed by the user.
     *
     * @param  $user
     * @param  $admin
     * 
     * @return bool
     */
    public function view($user, $admin)
    {
        return true;
    }
}
