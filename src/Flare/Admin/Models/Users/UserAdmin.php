<?php

namespace LaravelFlare\Flare\Admin\Models\Users;

use LaravelFlare\Flare\Admin\Models\ModelAdmin;

class UserAdmin extends ModelAdmin
{
    /**
     * ModelAdmin Icon.
     *
     * Font Awesome Defined Icon, eg 'user' = 'fa-user'
     *
     * @var string
     */
    public static $icon = 'user';

    /**
     * List of ManagedModels.
     *
     * Note: This must either be a single Namespaced String
     * or an Array of Namespaced Strings
     */
    protected $managedModels = [
        \LaravelFlare\Flare\Admin\Models\Users\ManagedUser::class,
        \LaravelFlare\Flare\Admin\Models\Users\ManagedUserGroup::class,
    ];
}
