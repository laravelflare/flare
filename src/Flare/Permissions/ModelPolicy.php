<?php

namespace LaravelFlare\Flare\Permissions;

use LaravelFlare\Flare\Contarcts\ModelPolicyInterface;

class ModelPolicy implements ModelPolicyInterface
{
    /**
     * Determine if the given Model can be created by the user.
     *
     * @param  $user
     * @param  $model
     * 
     * @return bool
     */
    public function create($user, $model)
    {
        return true;
    }

    /**
     * Determine if the given Model can be viewed by the user.
     *
     * @param  $user
     * @param  $model
     * 
     * @return bool
     */
    public function view($user, $model)
    {
        return true;
    }

    /**
     * Determine if the given Model can be updated by the user.
     *
     * @param  $user
     * @param  $model
     * 
     * @return bool
     */
    public function update($user, $model)
    {
        return true;
    }

    /**
     * Determine if the given Model can be deleted by the user.
     *
     * @param  $user
     * @param  $model
     * 
     * @return bool
     */
    public function delete($user, $model)
    {
        return true;
    }
}
