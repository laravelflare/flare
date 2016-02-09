<?php

namespace LaravelFlare\Flare\Admin\Attributes;

class AttributeManager
{
    /**
     * Render Attribute.
     *
     * @param string $action
     * @param string $attribute
     * @param string $field
     * @param string $model
     * @param string $modelManager
     *
     * @return \Illuminate\Http\Response
     */
    public function renderAttribute($action, $attribute, $field, $model, $modelManager)
    {
        if (!isset($field['type'])) {
            throw new \Exception('Attribute Field Type cannot be empty or undefined.');
        }

        if ($this->attributeTypeExists($field['type'])) {
            $fieldType = $this->resolveAttributeClass($field['type']);

            return call_user_func_array([new $fieldType($attribute, $field, $model, $modelManager), camel_case('render_'.$action)], []);
        }

        return call_user_func_array([new BaseAttribute($attribute, $field, $model, $modelManager), camel_case('render_'.$action)], []);
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
     * Determines if an AttributeType class exists or not.
     * 
     * @param string $type
     * 
     * @return bool
     */
    protected function attributeTypeExists($type)
    {
        return $this->resolveAttributeClass($type) ? true : false;
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
        if (class_exists($type)) {
            return $type;
        }

        if (array_key_exists($type, $attributes = $this->availableAttributes())) {
            return $this->availableAttributes()[$type];
        }

        return false;
    }
}
