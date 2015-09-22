<?php

namespace LaravelFlare\Flare\Admin\Attributes;

class BaseAttribute
{
    const ATTRIBUTE_TYPE = '';

    public $viewpath ='flare::admin.attributes';

    protected $attribute;

    protected $field;

    protected $model;

    public function __construct($attribute, $field, $model = false, $modelManager = false)
    {
        $this->attribute = $attribute;
        $this->field = $field;
        $this->model = $model;
        $this->modelManager = $modelManager;

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

    protected function getAttribute()
    {
        return $this->attribute;
    }

    protected function getField()
    {
        return $this->field;
    }

    protected function getModel()
    {
        return $this->model;
    }

    protected function getModelManager()
    {
        return $this->modelManager;
    }

    protected function getAttributeType()
    {
        return title_case( isset($this->getField()['type']) ? $this->getField()['type'] : self::ATTRIBUTE_TYPE );
    }

    protected function viewShare()
    {
        view()->share([
                        'model' => $this->getModel(), 
                        'field' => $this->getField(),
                        'attribute' => $this->getAttribute(), 
                        'attributeType' => $this->getAttributeType(), 
                        'attributeTitle' => title_case($this->getAttribute()), 
                    ]);
    }
}
