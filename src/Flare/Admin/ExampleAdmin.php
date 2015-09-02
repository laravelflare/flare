<?php

namespace JacobBaileyLtd\Flare\Admin;

use JacobBaileyLtd\Flare\Admin\ModelAdmin;
use JacobBaileyLtd\Flare\Contracts\PermissionsContract;

class ExampleAdmin extends ModelAdmin implements PermissionsContract
{
    use \JacobBaileyLtd\Flare\Traits\Permissionable;

    /**
     * List of managed {@link Model}s 
     * 
     * @var array|string
     */
    protected $managedModels = null;
}
