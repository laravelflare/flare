<?php

namespace LaravelFlare\Flare\Admin\Attributes;

class BaseAttribute
{
    /**
     * Attribute Type Constant
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
    public $viewpath ='flare::admin.attributes';

    /**
     * Attribute
     * 
     * @var string
     */
    protected $attribute;

    /**
     * Field
     * 
     * @var mixed
     */
    protected $field;

    /**
     * Eloquent Model
     * 
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $model;

    /**
     * __construct
     * 
     * @param string  $attribute    
     * @param mixed   $field        
     * @param boolean $model        
     * @param boolean $modelManager 
     */
    public function __construct($attribute, $field, $model = false, $modelManager = false)
    {
        $this->attribute = $attribute;
        $this->field = $field;
        $this->model = $model;
        $this->modelManager = $modelManager;

        $this->viewShare();
    }

    /**
     * Renders the Add (Create) Field View
     * 
     * @return \Illuminate\Http\Response
     */
    public function renderAdd()
    {
        return view($this->viewpath.'.add', []);
    }

    /**
     * Renders the Edit (Update) Field View
     * 
     * @return \Illuminate\Http\Response
     */
    public function renderEdit()
    {
        return view($this->viewpath.'.edit', []);
    }

    /**
     * Renders the Viewable Field View
     * 
     * @return \Illuminate\Http\Response
     */
    public function renderView()
    {
        return view($this->viewpath.'.view', []);
    }

    /**
     * Accessor for Attribute
     * 
     * @return string
     */
    public function getAttribute()
    {
        return $this->attribute;
    }

    /**
     * Accessor for Field
     * 
     * @return mixed
     */
    public function getField()
    {
        return $this->field;
    }

    /**
     * Accessor for Model
     * 
     * @var \Illuminate\Database\Eloquent\Model
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * Accessor for Model
     * 
     * @var \LaravelFlare\Flare\Admin\Models\ManagedModel
     */
    public function getModelManager()
    {
        return $this->modelManager;
    }

    /**
     * Acessor for Attribute Type converted to Title Case
     * 
     * @return string
     */
    public function getAttributeType()
    {
        return title_case( isset($this->getField()['type']) ? $this->getField()['type'] : self::ATTRIBUTE_TYPE );
    }

    /**
     * Shares all of the accessible date to the Attribute View
     * 
     * @return void
     */
    protected function viewShare()
    {
        view()->share([
                        'field' => $this->getField(),
                        'model' => $this->getModel(), 
                        'attribute' => $this->getAttribute(), 
                        'modelManager' => $this->getModelManager(), 
                        'attributeType' => $this->getAttributeType(), 
                        'attributeTitle' => title_case($this->getAttribute()), 
                    ]);
    }
}