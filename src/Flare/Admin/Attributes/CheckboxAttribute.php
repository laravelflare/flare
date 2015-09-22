<?php

namespace LaravelFlare\Flare\Admin\Attributes;

use LaravelFlare\Flare\Admin\Attributes\BaseAttribute;

class CheckboxAttribute extends BaseAttribute
{    
    /**
     * View Path for this Attribute Type
     *     Defaults to flare::admin.attributes which outputs
     *     a warning callout notifying the user that the field
     *     view does not yet exist.
     *     
     * @var string
     */
    public $viewpath = 'flare::admin.attributes.checkbox';
}