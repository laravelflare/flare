<?php

namespace AdenFraser\Flare\Traits;

trait Permissionable
{
    /**
     * Permission Provider
     * 
     * @return 
     */
    public function providePermissions()
    {
        return;
    }

    /**
     * Can the current User Create
     * 
     * @return 
     */
    public function canCreate()
    {
        Permissions::check();
    }

    /**
     * Can the current User View
     * 
     * @return 
     */
    public function canView()
    {
        Permissions::check();
    }

    /**
     * Can the current User Edit
     * 
     * @return 
     */
    public function canEdit()
    {
        Permissions::check();
    }

    /**
     * Can the current User View
     * 
     * @return 
     */
    public function canDelete()
    {
        Permissions::check();
    }
}