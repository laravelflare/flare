<?php

namespace JacobBaileyLtd\Flare\Admin\Models\Users;

use App\Models\User as User;
use JacobBaileyLtd\Flare\Admin\Models\ModelAdmin;

class UserAdmin extends ModelAdmin
{
    /**
     * List of ManagedModels.
     *
     * Note: This must either be a single Namespaced String
     * or an Array of Namespaced Strings
     *
     * Perhaps in the future we will allow App\Models\ManagedModel::class format aswell!
     */
    protected $managedModels = [
        'JacobBaileyLtd\Flare\Admin\Models\Users\ManagedUser',
        'JacobBaileyLtd\Flare\Admin\Models\Users\ManagedUserGroup'
    ];
}
