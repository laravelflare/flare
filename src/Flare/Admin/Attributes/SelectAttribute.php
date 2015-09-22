<?php

namespace LaravelFlare\Flare\Admin\Attributes;

use LaravelFlare\Flare\Admin\Attributes\BaseAttribute;

class SelectAttribute extends BaseAttribute
{
    public $viewpath = 'flare::admin.attributes.select';

    protected function getField()
    {
        $this->field = parent::getField();

        if (is_string($this->field['options']) && method_exists($this->getModelManager(), $method = camel_case('get_'.$this->field['options'].'_options'))) {
            $this->field['options'] = $this->getModelManager()->$method();
        } else if (is_string($this->field['options'])) {
            $this->field['options'] = explode(',', $this->field['options']);
        }

        return $this->field;
    }
}