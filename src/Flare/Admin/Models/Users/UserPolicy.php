<?php

namespace LaravelFlare\Flare\Admin\Models\Users;

class UserPolicy
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
