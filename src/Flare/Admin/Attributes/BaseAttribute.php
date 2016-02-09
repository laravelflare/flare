<?php

namespace LaravelFlare\Flare\Admin\Attributes;

class BaseAttribute
{
    /**
     * Attribute Type Constant.
     */
    const ATTRIBUTE_TYPE = '';

    /**
     * View Path for this Attribute Type
     *     Defaults to flare::admin.attributes which outputs
     *     a warning callout notifying the user that the field
     *     view does not yet exist.
     *     
     * @var string
     */
    protected $viewpath = 'flare::admin.attributes';

    /**
     * Attribute.
     * 
     * @var string
     */
    protected $attribute;

    /**
     * Field.
     * 
     * @var mixed
     */
    protected $field;

    /**
     * Eloquent Model.
     * 
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $model;

    /**
     * Model Manager.
     * 
     * @var \LaravelFlare\Flare\Admin\Models\ModelAdmin
     */
    protected $modelManager;

    /**
     * __construct.
     * 
     * @param string $attribute
     * @param string $field
     * @param string $model
     * @param string $modelManager
     */
    public function __construct($attribute, $field, $model = null, $modelManager = null)
    {
        $this->attribute = $attribute;
        $this->field = $field;
        $this->model = $model;
        $this->modelManager = $modelManager;
    }

    /**
     * Renders the Add (Create) Field View.
     * 
     * @return \Illuminate\View\View
     */
    public function renderAdd()
    {
        return view($this->viewpath.'.add', $this->viewData());
    }

    /**
     * Renders the Edit (Update) Field View.
     * 
     * @return \Illuminate\View\View
     */
    public function renderEdit()
    {
        return view($this->viewpath.'.edit', $this->viewData());
    }

    /**
     * Renders the Clone (Update) Field View.
     * 
     * @return \Illuminate\View\View
     */
    public function renderClone()
    {
        if (view()->exists($this->viewpath.'.clone')) {
            view($this->viewpath.'.clone', $this->viewData());
        }

        return view($this->viewpath.'.edit', $this->viewData());
    }

    /**
     * Renders the Viewable Field View.
     * 
     * @return \Illuminate\View\View
     */
    public function renderView()
    {
        return view($this->viewpath.'.view', $this->viewData());
    }

    /**
     * Getter for Attribute.
     * 
     * @return string
     */
    public function getAttribute()
    {
        return $this->attribute;
    }

    /**
     * Getter for Field.
     * 
     * @return mixed
     */
    public function getField()
    {
        $this->getFieldOptions();

        return $this->field;
    }

    /**
     * Gets Field Options if they are defined.
     */
    public function getFieldOptions()
    {
        if (method_exists($this->getModelManager(), $method = camel_case('get_'.$this->getAttribute().'_options'))) {
            // First check for a method of options based on getAttributeNameOptions()
            $this->field['options'] = $this->getModelManager()->$method();
        } elseif (isset($this->field['options']) && is_string($this->field['options']) && method_exists($this->getModelManager(), $method = camel_case('get_'.$this->field['options'].'_options'))) {
            // Check if Options is a string and if so, check for a method
            // of options based on getDefinedOptions()
            $this->field['options'] = $this->getModelManager()->$method();
        } elseif (isset($this->field['options']) && is_string($this->field['options'])) {
            // Otherwise, if the options have been provided as a string
            // we will assume that the available options are comma
            // delimited and explode and return that array.
            $this->field['options'] = explode(',', $this->field['options']);
        }
    }

    /**
     * Accessor for Model.
     * 
     * @var \Illuminate\Database\Eloquent\Model
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * Accessor for Model.
     * 
     * @var \LaravelFlare\Flare\Admin\Models\ModelAdmin
     */
    public function getModelManager()
    {
        return $this->modelManager;
    }

    /**
     * Acessor for Attribute Type converted to Title Case.
     * 
     * @return string
     */
    public function getAttributeType()
    {
        return title_case(isset($this->getField()['type']) ? $this->getField()['type'] : self::ATTRIBUTE_TYPE);
    }

    /**
     * Acessor for Attribute Title converted to Title Case with Spaces.
     * 
     * @return string
     */
    public function getAttributeTitle()
    {
        return str_replace('_', ' ', title_case($this->getAttribute()));
    }

    /**
     * Returns all of the accessible data for the Attirbute View
     *
     * @return array
     */
    protected function viewData()
    {
        return [
                'field' => $this->getField(),
                'model' => $this->getModel(),
                'attribute' => $this->getAttribute(),
                'modelManager' => $this->getModelManager(),
                'attributeType' => $this->getAttributeType(),
                'attributeTitle' => $this->getAttributeTitle(),
            ];
    }
}
