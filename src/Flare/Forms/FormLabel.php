<?php

namespace LaravelFlare\Flare\Forms;

class FormLabel
{{
    /**
     * Field Name.
     * 
     * @var string
     */
    protected $name;

    /**
     * Field Title (Human Readbable Field Label).
     * 
     * @var string
     */
    protected $title;

    /**
     * __construct
     */
    public function __construct()
    {
        $this->name = $name;
        $this->title = ($title === null) ? self::nameToLabel($name) : $title;
    }
    
    /**
     * Render a form field
     * 
     * @return string
     */
    public function render()
    {
        return '<label for="'.$this->name().'_Input">'.$this->title().'</label>';
    }

    /**
     * Creates a new static FormField and returns the rendered view
     * 
     * @param string $name  Field Name
     * @param string $title The human-readable field label.
     * @param mixed  $value The value of the field.
     * 
     * @return 
     */
    public static function renderNew($name, $title = null)
    {
        return (new static($name, $title))->render();
    }
    
    /**
     * Returns the Label Name
     * 
     * @return 
     */
    public function name()
    {
        return $this->name;
    }

    /**
     * Returns the Label Title
     * 
     * @return
     */
    public function title()
    {
        return $this->title;
    }

    /**
     * Takes a fieldname and converts camelcase to spaced
     * words. Also resolves combined fieldnames with dot syntax
     * to spaced words.
     *
     * @param string $fieldName
     *
     * @return string
     */
    public static function nameToLabel($fieldName)
    {
        if (strpos($fieldName, '.') !== false) {
            $parts = explode('.', $fieldName);
            $label = $parts[count($parts) - 2].' '.$parts[count($parts) - 1];
        } else {
            $label = $fieldName;
        }

        $label = preg_replace('/([a-z]+)([A-Z])/', '$1 $2', $label);

        return $label;
    }
}
