<?php

namespace JacobBaileyLtd\Flare\Traits\Attributes;

use JacobBaileyLtd\Flare\Traits\Attributes\ViewModelAttribute;
use JacobBaileyLtd\Flare\Traits\Attributes\EditModelAttribute;
use JacobBaileyLtd\Flare\Traits\Attributes\UpdateModelAttribute;

trait AttributeAccess
{
    use ViewModelAttribute, EditModelAttribute, UpdateModelAttribute;

// I'M NOT SURE HOW THIS SECTION IS GOING TO WORK YET,
// THE THEORY WORKS FINE IF ONE MODEL IS MANAGED, BUT
// HOW DO WE DEFINE A KEY IF MORE THAN ONE MODEL IS
// DEFINED?


    protected function attributeFromMethod($method) 
    {
        if(strlen(($attribute = substr(substr($method, 0, -9), 4))) > 0) {
            return $attribute;
        }

        return $method;
    }

    /**
     * [attributeType description]
     * @param  [type] $key [description]
     * @return [type]      [description]
     */
    protected function attributeType($key)
    {
        // We might do a lookup for custom attribute types in a lookup array at some point
        // but for now, ignore this method.
    }

}