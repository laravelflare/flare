<?php

namespace JacobBaileyLtd\Flare\Forms;

/**
 * We might remove this and implement Laravel Collective Forms.
 */
class FormField
{
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
     * Value of Field.
     * 
     * @var null
     */
    protected $value = null;

    /**
     * Creates a new form field.
     *
     * @param string $name  Field Name
     * @param string $title The human-readable field label.
     * @param mixed  $value The value of the field.
     */
    public function __construct($name, $title = null, $value = null)
    {
        $this->name = $name;
        $this->title = ($title === null) ? self::name_to_label($name) : $title;
        if ($value !== null) {
            $this->value = $value;
        }
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
    public static function name_to_label($fieldName)
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

    public function __toString()
    {
        return '
            <label for="'.$this->name.'_Input">'.$this->title.'</label>
            <input type="text" name="'.$this->name.'" value="'.$this->value.'" id="'.$this->name.'_Input">
        ';
    }
}
