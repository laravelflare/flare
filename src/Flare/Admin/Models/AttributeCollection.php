<?php

namespace LaravelFlare\Flare\Admin\Models;

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
    protected $modelManager;

    /**
     * Create a new collection.
     *
     * @param mixed $items
     */
    public function __construct($items = [], $modelManager = null)
    {
        $this->fields = \App::make(FieldManager::class);
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
            return $this->fields->create($inner, $name, $this->getValue(), $inner);
        }

        if (is_array($inner) && array_key_exists('type', $inner) && is_scalar($inner['type']) && $this->fields->typeExists($inner['type'])) {
            $type = $inner['type'];
            array_forget($inner, 'type');

            return $this->fields->create($type, $name, $this->getValue(), $inner);
        }

        if (is_array($inner)) {
            $formattedItems = [];

            foreach ($inner as $name => $inner) {
                $formattedItems[$name] = $this->formatInnerField($inner);
            }

            return $formattedItems;
        }
    }

    private function getValue()
    {
    }
}
