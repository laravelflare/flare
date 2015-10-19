<?php

namespace LaravelFlare\Flare\Admin\Attributes;

class WysiwygAttribute extends BaseAttribute
{
    /**
     * View Path for this Attribute Type
     *     Defaults to flare::admin.attributes which outputs
     *     a warning callout notifying the user that the field
     *     view does not yet exist.
     *     
     * @var string
     */
    public $viewpath = 'flare::admin.attributes.wysiwyg';
}
