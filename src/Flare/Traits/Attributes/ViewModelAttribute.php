<?php

namespace JacobBaileyLtd\Flare\Traits\Attributes;

use Illuminate\Support\Str;

trait ViewModelAttribute
{
    /**
     * Determine if an attribute has a view defined.
     *
     * @param string $key
     * 
     * @return bool
     */
    public function hasView($key = false)
    {
        return method_exists($this, 'view'.Str::studly($key).'Attribute');
    }

    /**
     * Get the view of an attribute.
     *
     * @param string $key
     * @param mixed  $value
     * 
     * @return mixed
     */
    protected function viewAttribute($key)
    {
        return $this->{'view'.Str::studly($key).'Attribute'}();
    }

    /**
     * If the requested Attribute View has been custom defined, load that
     * otherwise we will load the defaultViewAttribute method.
     * 
     * @param string $key
     * 
     * @return          
     */
    protected function getViewAttribute($method, $attribute = false)
    {
        if (!$attribute && $this->hasView($key = substr(substr($method, 0, -9), 4))) {
            return call_user_func(array($this, 'view'.Str::studly($key).'Attribute'), [$key]);
        }

        return $this->defaultViewAttribute($method, $attribute);
    }

    /**
     * Returns the default Attribute View for the Model Attribute.
     *
     * @param string $key
     * 
     * @return       
     */
    protected function defaultViewAttribute($method, $attribute = false)
    {
        // Returns the Attribute View which will probably be a blade tempalte as a string, but this could be overridden with a ClassName->__toString() or even just a string.
        return view('flare::admin.attributes.default.view', ['value' => ($attribute ? $attribute : $this->attributeFromMethod($method))]);
    }
}
