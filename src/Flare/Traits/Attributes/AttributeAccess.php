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

    public function getMapping()
    {
        return $this->mapping;
    }

    protected function attributeFromMethod($method)
    {
        if (strlen(($attribute = substr(substr($method, 0, -9), 4))) > 0) {
            return $attribute;
        }

        return $method;
    }

    /**
     * @param string $key
     *
     * @return 
     */
    protected function attributeType($key)
    {
        // We might do a lookup for custom attribute types in a lookup array at some point
        // but for now, ignore this method.
    }
}
