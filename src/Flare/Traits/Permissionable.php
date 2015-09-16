<?php

namespace Flare\Traits;

use Flare\Permissions\Permissions; // This should actually use a Permissions Implementation, so that the PermissionProvider class can be swapped out

trait Permissionable
{
    /**
     * Permission Provider.
     * 
     * @return 
     */
    public function providePermissions()
    {
        return;
    }

    /**
     * Can the current User Create.
     * 
     * @return 
     */
    public function canCreate()
    {
        // Check Model Permissions First
        Permissions::check();

        // Check Individual Method Permissions
    }

    /**
     * Can the current User View.
     * 
     * @return 
     */
    public function canView()
    {
        Permissions::check();
    }

    /**
     * Can the current User Edit.
     * 
     * @return 
     */
    public function canEdit()
    {
        Permissions::check();
    }

    /**
     * Can the current User View.
     * 
     * @return 
     */
    public function canDelete()
    {
        Permissions::check();
    }
}
