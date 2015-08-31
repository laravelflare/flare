<?php

namespace AdenFraser\Flare\Admin;

use AdenFraser\Flare\Admin\ModelAdmin;
use AdenFraser\Flare\Contracts\PermissionsContract;

class ExampleAdmin extends ModelAdmin implements PermissionsContract
{
    use \AdenFraser\Flare\Traits\Permissionable;

    /**
     * List of managed {@link Model}s 
     * 
     * @var array|string
     */
    protected $managedModels = null;

    /**
     * Overrides the default Title with a custom set one. 
     * The use of $title and $pluralTitle is preferred
     * to overriding the Title() method.
     *
     * @return string
     */
    //public static function Title()
   
     
}
