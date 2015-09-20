<?php

namespace LaravelFlare\Flare\Admin\Attributes;

class BaseAttribute
{
    const ATTRIBUTE_TYPE = '';

    public $viewpath ='flare::admin.attributes';

    public function __construct($attribute, $field, $model = false)
    {
        $this->attribute = $attribute;
        $this->field = $field;
        $this->model = $model;

        $this->viewShare();
    }

    public function renderAdd()
    {
        return view($this->viewpath.'.add', []);
    }

    public function renderEdit()
    {
        return view($this->viewpath.'.edit', []);
    }

    public function renderView()
    {
        return view($this->viewpath.'.view', []);
    }

    protected function getAttributeType()
    {
        return title_case( isset($this->field['type']) ? $this->field['type'] : self::ATTRIBUTE_TYPE );
    }

    protected function viewShare()
    {
        view()->share([
                        'model' => $this->model, 
                        'field' => $this->field,
                        'attribute' => $this->attribute, 
                        'attributeType' => $this->getAttributeType(), 
                        'attributeTitle' => title_case($this->attribute), 
                    ]);
    }
}
