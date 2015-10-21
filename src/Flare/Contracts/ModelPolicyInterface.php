<?php

namespace LaravelFlare\Flare\Contracts;

interface ModelPolicyInterface
{
    /**
     * Determine if the given Model can be created by the user.
     *
     * @param  $user
     * @param  $model
     * 
     * @return bool
     */
    public function create($user, $model);

    /**
     * Determine if the given Model can be viewed by the user.
     *
     * @param  $user
     * @param  $model
     * 
     * @return bool
     */
    public function view($user, $model);

    /**
     * Determine if the given Model can be updated by the user.
     *
     * @param  $user
     * @param  $model
     * 
     * @return bool
     */
    public function update($user, $model);

    /**
     * Determine if the given Model can be deleted by the user.
     *
     * @param  $user
     * @param  $model
     * 
     * @return bool
     */
    public function delete($user, $model);
}
