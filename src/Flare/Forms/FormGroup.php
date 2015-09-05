<?php

namespace JacobBaileyLtd\Flare\Forms;

class FormGroup
{
    /**
     * @var FormLabel
     */
    protected $label;

    /**
     * @var FormField
     */
    protected $field;

    /**
     * @var string
     */
    protected $helpText;

    /**
     * __construct.
     * 
     * @param FormLabel $label [description]
     * @param FormField $field [description]
     */
    public function __construct(FormLabel $label, FormField $field)
    {
        $this->label = $label;
        $this->field = $field;
    }

    /**
     * Adds HelpText to the FormGroup.
     * 
     * @param string $helpText
     *
     * @return FormGroup
     */
    public function addHelpText($helpText)
    {
        if (!$helpText) {
            return;
        }

        $this->helpText = $helpText;

        return $this;
    }

    /**
     * Render a form field.
     * 
     * @return string
     */
    public function render()
    {
        return '<p>'.
            $this->label()->render().
            $this->field()->render().
        '</p>';
    }

    /**
     * Creates a new static FormField and returns the rendered view.
     * 
     * @param FormLabel $label [description]
     * @param FormField $field [description]
     * 
     * @return 
     */
    public static function renderNew(FormLabel $label, FormField $field)
    {
        return (new static($label, $field))->render();
    }

    /**
     * Returns the FormLabel instance.
     * 
     * @return 
     */
    public function label()
    {
        return $this->label;
    }

    /**
     * Returns the FormField instance.
     * 
     * @return
     */
    public function field()
    {
        return $this->field;
    }

    /**
     * Returns the raw help text.
     *
     *  In future we should move this to a FormHelpText class
     *  
     * @return
     */
    public function helpText()
    {
        return $this->helpText;
    }
}
