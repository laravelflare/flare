<?php

namespace LaravelFlare\Flare\Admin\Attributes;

class AttributeManager
{
    /**
     * Create a new Attribute Instance 
     * 
     * @param string $type
     * @param string $action
     * @param string $attribute
     * @param string $field
     * @param string $modelManager
     */
    public function createAttribute($type, $attribute, $field, $modelManager = null)
    {
        if ($this->attributeTypeExists($type)) {
            $fieldType = $this->resolveAttributeClass($type);

            return new $fieldType($attribute, $field, $value = null, $modelManager);
        }

        return new BaseAttribute($attribute, $field, $value = null, $modelManager);
    }

    /**
     * Render Attribute.
     *
     * @param string $action
     * @param string $attribute
     * @param string $field
     * @param string $modelManager
     *
     * @return \Illuminate\Http\Response
     */
    public function renderAttribute($action, $attribute, $field, $modelManager = null)
    {
        if (!isset($field['type'])) {
            throw new \Exception('Attribute Field Type cannot be empty or undefined.');
        }

        return call_user_func_array([$this->createAttribute($field['type'], $action, $attribute, $field, $value = null, $modelManager), camel_case('render_'.$action)], []);
    }

    /**
     * Determines if an AttributeType class exists or not.
     * 
     * @param string $type
     * 
     * @return bool
     */
    public function attributeTypeExists($type)
    {
        return $this->resolveAttributeClass($type) ? true : false;
    }

    /**
     * Returns an array of all of the Available Attribute Types.
     * 
     * @return array
     */
    protected function availableAttributes()
    {
        $availableAttributes = [];

        foreach (\Flare::config('attributes') as $attributeType => $attributeFullClassname) {
            $availableAttributes = array_add(
                                            $availableAttributes,
                                            $attributeType,
                                            $attributeFullClassname
                                        );
        }

        return $availableAttributes;
    }

    /**
     * Resolves the Class of an Attribute and returns it as a string.
     * 
     * @param string $type
     * 
     * @return string
     */
    protected function resolveAttributeClass($type)
    {
        if (array_key_exists($type, $attributes = $this->availableAttributes())) {
            return $this->availableAttributes()[$type];
        }

        if (class_exists($type)) {
            return $type;
        }

        return false;
    }
}
