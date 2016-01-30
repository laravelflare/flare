<?php

namespace LaravelFlare\Flare\Admin\Attributes;

class ImageAttribute extends BaseAttribute
{
    /**
     * View Path for this Attribute Type
     *     Defaults to flare::admin.attributes which outputs
     *     a warning callout notifying the user that the field
     *     view does not yet exist.
     *     
     * @var string
     */
    protected $viewpath = 'flare::admin.attributes.image';
}
