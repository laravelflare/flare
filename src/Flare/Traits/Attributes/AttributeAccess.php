<?php

namespace LaravelFlare\Flare\Traits\Attributes;

trait AttributeAccess
{
    /**
     * Map Model Attributes to AttributeTypes with
     * additional parameters which will be output
     * as fields when viewing, editting or adding
     * a new model entry.
     * 
     * @var array
     */
    protected $fields = [];

    /**
     * Gets the Managed Model Mapping.
     * 
     * @return array
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * Returns an Attribute from a Method.
     * 
     * @param string $method
     * 
     * @return string
     */
    protected function attributeFromMethod($method)
    {
        if (strlen(($attribute = substr(substr($method, 0, -9), 4))) > 0) {
            return $attribute;
        }

        return $method;
    }
}
