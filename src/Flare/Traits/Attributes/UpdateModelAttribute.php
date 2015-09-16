<?php

namespace Flare\Traits\Attributes;

use Illuminate\Support\Str;

trait UpdateModelAttribute
{
    /**
     * Determine if an attribute has Field update logic defined.
     *
     * @param string $key
     * 
     * @return bool
     */
    public function hasUpdate($key)
    {
        return method_exists($this, 'update'.Str::studly($key).'Attribute');
    }

    /**
     * Update the value of an attribute.
     *
     * @param string $key
     * @param mixed  $value
     * 
     * @return mixed
     */
    protected function updateAttribute($key, $value)
    {
        return $this->{'update'.Str::studly($key).'Attribute'}($value);
    }

    /**
     * If the requested Update Attribute has been custom defined, use that
     * otherwise we will load the defaultUpdateAttribute method.
     * 
     * @param string $key
     * 
     * @return          
     */
    protected function getUpdateAttribute($key, $value)
    {
        if ($this->hasUpdate($key = substr(substr($method, 0, -9), 4))) {
            return call_user_func_array(array($this, 'update'.Str::studly($key).'Attribute'), [$key, $value]);
        }

        return $this->defaultUpdateAttribute($key, $value);
    }

    /**
     * Performs the default Attribute Update Action for the Model Attribute
     * Which in essence, is just the setAttribute action.
     * 
     * @param string $key
     * 
     * @return       
     */
    protected function defaultUpdateAttribute($key, $value)
    {
        return call_user_func_array(array($this, 'set'.Str::studly($key).'Attribute', [$value]));
    }
}
