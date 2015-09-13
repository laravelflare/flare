<?php

namespace JacobBaileyLtd\Flare\Models\Admin;

use JacobBaileyLtd\Flare\Traits\Permissionable;
use JacobBaileyLtd\Flare\Contracts\PermissionsContract;
use JacobBaileyLtd\Flare\Traits\ModelAdmin\ModelWriteable;
use JacobBaileyLtd\Flare\Traits\ModelAdmin\ModelValidation;
use JacobBaileyLtd\Flare\Traits\Attributes\AttributeAccess;
use JacobBaileyLtd\Flare\Contracts\ModelAdmin\ModelWriteableContract;
use JacobBaileyLtd\Flare\Contracts\ModelAdmin\ModelValidationContract;

class ManagedModel implements PermissionsContract, ModelValidationContract, ModelWriteableContract
{
    use AttributeAccess, ModelValidation, ModelWriteable, Permissionable;

    
}
