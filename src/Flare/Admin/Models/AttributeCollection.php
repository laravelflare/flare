<?php

namespace LaravelFlare\Flare\Admin\Models;

use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use LaravelFlare\Fields\FieldManager;
use LaravelFlare\Fields\Types\BaseField;

class AttributeCollection extends Collection
{
    /**
     * The items contained in the collection.
     *
     * @var array
     */
    protected $items = [];

    /**
     * Field Manager Instance.
     * 
     * @var \LaravelFlare\Fields\FieldManager
     */
    protected $fields;

    /**
     * ModelAdmin which contains this Attribute Collection.
     * 
     * @var \LaravelFlare\Flare\Admin\Models\ModelAdmin
     */
    public $modelManager;

    /**
     * Create a new collection.
     *
     * @param mixed $items
     */
    public function __construct($items = [], $modelManager = null)
    {
        $this->fields = app(FieldManager::class);
        $this->items = $items;
        $this->modelManager = $modelManager;

        $this->formatFields();
    }

    /**
     * Attempt to reformat the current attribute items array
     * into the most usable format (an Attribute Collection).
     */
    public function formatFields()
    {
        $items = $this->items;
        $formattedItems = [];

        foreach ($items as $name => $inner) {
            $formattedItems[$name] = $this->formatInnerField($name, $inner);
        }

        $this->items = $formattedItems;

        return $this;
    }

    /**
     * Allows adding fields to the Attribute Collection.
     * 
     * @param array $items
     */
    public function add($items = [])
    {
        if (!is_array($items) || func_num_args() > 1) {
            $items = func_get_args();
        }

        $this->push($this->formatInnerField(null, $items));
    }

    /**
     * Format an Inner Field which can either be in the format
     * of an Array, an instance of BaseAttribute or even an
     * AttributeCollection object (which contains more!).
     *
     * @param mixed $name
     * @param mixed $inner
     * 
     * @return mixed
     */
    protected function formatInnerField($name = null, $inner = [])
    {
        if ($inner instanceof BaseField) {
            return $inner;
        }

        if ($inner instanceof self) {
            $formattedItems = [];

            foreach ($inner->toArray() as $name => $inner) {
                $formattedItems[$name] = $this->formatInnerField($inner);
            }

            return $formattedItems;
        }

        if (is_scalar($inner) && $this->fields->typeExists($inner)) {
            return $this->createField($inner, $name, $this->getValue($name), $inner);
        }

        if (is_array($inner) && array_key_exists('type', $inner) && is_scalar($inner['type']) && $this->fields->typeExists($inner['type'])) {
            $type = $inner['type'];
            array_forget($inner, 'type');

            return $this->createField($type, $name, $this->getValue($name), $inner);
        }

        if (is_array($inner)) {
            $formattedItems = [];

            foreach ($inner as $name => $inner) {
                $formattedItems[$name] = $this->formatInnerField($inner);
            }

            return $formattedItems;
        }
    }

    /**
     * Create and return a Field Instance.
     * 
     * @param mixed  $type
     * @param string $name
     * @param string $value
     * @param mixed  $inner
     * 
     * @return 
     */
    private function createField($type, $name, $value, $inner)
    {
        if ($this->hasOptionsMethod($name)) {
            $inner = array_merge($inner, ['options' => $this->getOptions($name)]);
        }

        return $this->fields->create($type, $name, $this->getValue($name), $inner);
    }

    /**
     * Get any dynamic options for an attribute.
     * 
     * @param string $name
     * 
     * @return mixed
     */
    private function getOptions($name)
    {
        $method = 'get'.Str::studly($name).'Options';

        return $this->modelManager->{$method}();
    }

    /**
     * Determine if an options method exists for an attribute.
     *
     * @param string $key
     * 
     * @return bool
     */
    public function hasOptionsMethod($key)
    {
        return method_exists($this->modelManager, 'get'.Str::studly($key).'Options');
    }

    /**
     * Get the value of an attribute for the field.
     * 
     * @param string $name
     * 
     * @return mixed
     */
    private function getValue($name)
    {
        if (!$name) {
            return;
        }

        return $this->modelManager->getAttribute($name);
    }
}
