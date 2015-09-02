<?php

namespace JacobBaileyLtd\Flare\Admin\Users;

use App\Models\User as User;
use JacobBaileyLtd\Flare\Admin\ModelAdmin;
use JacobBaileyLtd\Flare\Contracts\PermissionsContract;

class UserAdmin extends ModelAdmin implements PermissionsContract
{
    use \JacobBaileyLtd\Flare\Traits\Permissionable;

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
