<?php

namespace LaravelFlare\Flare\Forms;

class FormField
{
    /**
     * Field Name.
     * 
     * @var string
     */
    protected $name;

    /**
     * Value of Field.
     * 
     * @var null
     */
    protected $value = null;

    /**
     * Creates a new form field.
     *
     * @param string $name  Field Name
     * @param mixed  $value The value of the field.
     */
    public function __construct($name, $value = null)
    {
        $this->name = $name;
        if ($value !== null) {
            $this->value = $value;
        }
    }

    /**
     * Render a form field.
     * 
     * @return
     */
    public function render()
    {
        return '<input type="text" name="'.$this->name().'" value="'.$this->value().'" id="'.$this->name().'_Input">';
    }

    /**
     * Return the Field Name.
     * 
     * @return 
     */
    public function name()
    {
        return $this->name;
    }

    /**
     * Return the Field Value.
     * 
     * @return
     */
    public function value()
    {
        return $this->value;
    }

    /**
     * Creates a new static FormField and returns the rendered view.
     * 
     * @param string $name  Field Name
     * @param mixed  $value The value of the field.
     * 
     * @return 
     */
    public static function renderNew($name, $title = null, $value = null)
    {
        return (new static($name, $value))->render();
    }

    /**
     * Retrospectively, this was a terrible idea for an implementation.
     * I didn't really think of the affect that a broken blade template would have
     * on the result of the __toString method.
     *
     * We should replace this with a view render.
     * 
     * @return string
     */
    public function __toString()
    {
    }
}
