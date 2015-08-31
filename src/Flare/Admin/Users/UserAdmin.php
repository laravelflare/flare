<?php

namespace AdenFraser\Flare\Admin\Users;

use App\Models\User as User;
use AdenFraser\Flare\Admin\ModelAdmin;
use AdenFraser\Flare\Contracts\PermissionsContract;

class UserAdmin extends ModelAdmin implements PermissionsContract
{
    use \AdenFraser\Flare\Traits\Permissionable;

    /**
     * List of managed {@link Model}s 
     *
     * Note: This must either be a single Namespaced String
     * or an Array of Namespaced Strings
     *
     * Perhaps in the future we will allow App\Models\Model::class format aswell!
     */
    protected $managedModels = 'App\Models\User';






}
