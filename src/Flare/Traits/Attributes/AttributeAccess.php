<?php

namespace LaravelFlare\Flare\Traits\Attributes;

trait AttributeAccess
{
    /**
     * Map Model Attributes to AttributeTypes with
     * additional parameters.
     * 
     * @var array
     */
    protected $mapping = [];

    /**
     * Gets the Managed Model Mapping.
     * 
     * @return array
     */
    public function getMapping()
    {
        return $this->mapping;
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
