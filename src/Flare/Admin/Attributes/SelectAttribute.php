<?php

namespace LaravelFlare\Flare\Admin\Attributes;

use LaravelFlare\Flare\Admin\Attributes\BaseAttribute;

class SelectAttribute extends BaseAttribute
{
    /**
     * View Path for this Attribute Type
     *     Defaults to flare::admin.attributes which outputs
     *     a warning callout notifying the user that the field
     *     view does not yet exist.
     *     
     * @var string
     */
    public $viewpath = 'flare::admin.attributes.select';

    /**
     * Accessor for Field
     *
     * Converts the Field Options which have been specified
     * into an array of usable options.
     * 
     * @return mixed
     */
    public function getField()
    {
        $this->field = parent::getField();

        if (is_string($this->field['options']) && method_exists($this->getModelManager(), $method = camel_case('get_'.$this->field['options'].'_options'))) {
            $this->field['options'] = $this->getModelManager()->$method();
        } else if (is_string($this->field['options'])) {
            $this->field['options'] = explode(',', $this->field['options']);
        }

        return $this->field;
    }
}