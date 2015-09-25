<?php

namespace LaravelFlare\Flare\Admin\Attributes;

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
     * Accessor for Field.
     *
     * Converts the Field Options which have been specified
     * into an array of usable options.
     * 
     * @return mixed
     */
    public function getField()
    {
        $this->field = parent::getField();

        if (method_exists($this->getModelManager(), $method = camel_case('get_'.$this->getAttribute().'_options'))) {
            // First check for a method of options based on getAttributeNameOptions()
            $this->field['options'] = $this->getModelManager()->$method();
        } elseif (isset($this->field['options']) && is_string($this->field['options']) && method_exists($this->getModelManager(), $method = camel_case('get_'.$this->field['options'].'_options'))) {
            // Check if Options is a string and if so, check for a method
            // of options based on getDefinedOptions()
            $this->field['options'] = $this->getModelManager()->$method();
        } elseif (isset($this->field['options']) && is_string($this->field['options'])) {
            // Otherwise, if the options have been provided as a string
            // we will assume that the available options are comma
            // delimited and explode and return that array.
            $this->field['options'] = explode(',', $this->field['options']);
        }

        // If no field options, throw a logic exception.

        return $this->field;
    }
}
