<?php

namespace JacobBaileyLtd\Flare\Traits\Attributes;

use Illuminate\Support\Str;

trait EditModelAttribute
{
    /**
     * Determine if an attribute has a Field view defined.
     *
     * @param string $key
     * 
     * @return bool
     */
    public function hasEdit($key = false)
    {
        return method_exists($this, 'view'.Str::studly($key).'Attribute');
    }

    /**
     * Get the Field view of an attribute.
     *
     * @param string $key
     * @param mixed  $value
     * 
     * @return mixed
     */
    protected function editAttribute($key)
    {
        return $this->{'field'.Str::studly($key).'Attribute'}();
    }

    /**
     * If the requested Attribute View has been custom defined, load that
     * otherwise we will load the defaultViewAttribute method.
     * 
     * @param string $key
     * 
     * @return          
     */
    protected function getEditAttribute($method, $attribute = false)
    {
        if ($this->hasView($key = substr(substr($method, 0, -9), 4))) {
            return call_user_func(array($this, 'edit'.Str::studly($key).'Attribute'), [$key]);
        }

        return $this->defaultEditAttribute($method, $attribute);
    }

    /**
     * Returns the default Attribute View for the Model Attribute.
     *
     * @param string $key
     * 
     * @return       
     */
    protected function defaultEditAttribute($method, $attribute = false)
    {
        //JacobBaileyLtd\Flare\Admin
        //                  We have removed AttributeField, use EditAttribute
        //return (string) new \JacobBaileyLtd\Flare\Admin\AttributeField($this->attributeFromMethod($method), $this->attributeFromMethod($method));
        // AttributeField as string
        // We will use __toString for this by defualt,
        // however, we can in theory return any string
        // here, blade view or even a __toString of
        // a FieldGroup :D
    }
}
