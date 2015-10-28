<?php

namespace LaravelFlare\Flare\Contracts\ModelAdmin;

interface ModelAdminPoliceable
{
    /**
     * Determine if the given Model can be created by the user.
     *
     * @param  $user
     * @param \LaravelFlare\Flare\Admin\Models\ModelAdmin $modelAdmin
     * 
     * @return bool
     */
    public function create($user, $modelAdmin);

    /**
     * Determine if the given Model can be viewed by the user.
     *
     * @param  $user
     * @param \LaravelFlare\Flare\Admin\Models\ModelAdmin $modelAdmin
     * 
     * @return bool
     */
    public function view($user, $modelAdmin);

    /**
     * Determine if the given Model can be updated by the user.
     *
     * @param  $user
     * @param \LaravelFlare\Flare\Admin\Models\ModelAdmin $modelAdmin
     * 
     * @return bool
     */
    public function update($user, $modelAdmin);

    /**
     * Determine if the given Model can be deleted by the user.
     *
     * @param  $user
     * @param \LaravelFlare\Flare\Admin\Models\ModelAdmin $modelAdmin
     * 
     * @return bool
     */
    public function delete($user, $modelAdmin);
}
