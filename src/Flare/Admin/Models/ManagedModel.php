<?php

namespace LaravelFlare\Flare\Admin\Models;

use Illuminate\Support\Str;
use LaravelFlare\Flare\Admin\Admin;
use LaravelFlare\Flare\Admin\Widgets\DefaultWidget;
use LaravelFlare\Flare\Traits\ModelAdmin\ModelQueryable;
use LaravelFlare\Flare\Traits\ModelAdmin\ModelWriteable;
use LaravelFlare\Flare\Traits\Attributes\AttributeAccess;
use LaravelFlare\Flare\Contracts\ModelAdmin\ModelWriteableInterface;

abstract class ManagedModel extends Admin implements ModelWriteableInterface
{
    use AttributeAccess, ModelWriteable, ModelQueryable;

    /**
     * Managed Model Icon.
     *
     * Font Awesome Defined Icon, eg 'user' = 'fa-user'
     *
     * @var string
     */
    public static $icon;

    /**
     * Managed Model Instance.
     * 
     * @var string
     */
    public $managedModel;

    /**
     * Model Instance.
     *
     * @var object
     */
    public $model;

    /**
     * Validation Rules for onCreate, onEdit actions.
     * 
     * @var array
     */
    protected $summary_fields = [];

    /**
     * Class Prefix used for matching and removing term
     * from user provided Admin sections.
     *
     * @var string
     */
    const CLASS_PREFIX = 'Managed';

    /**
     * __construct.
     */
    public function __construct($id = false)
    {
        if (!isset($this->managedModel) || $this->managedModel === null) {
            throw new \Exception('You have a ManagedModel which does not have a model assigned to it.', 1);
        }

        $managedModel = $this->managedModel;

        $this->model = new $managedModel();

        if ($id && $this->model) {
            $this->model = $this->model->find($id);
        }
    }

    /**
     * Formats and returns the Summary fields.
     *
     * This is really gross, I'm removing it soon.
     * 
     * @return
     */
    public function getSummaryFields()
    {
        $summary_fields = [];

        foreach ($this->summary_fields as $field => $fieldTitle) {
            if (in_array($field, $this->model->getFillable())) {
                if (!$field) {
                    $field = $fieldTitle;
                    $fieldTitle = Str::title($fieldTitle);
                }
                $summary_fields[$field] = $fieldTitle;
                continue;
            }

            if (($methodBreaker = strpos($field, '.')) !== false) {
                $method = substr($field, 0, $methodBreaker);
                if (method_exists($this->model, $method)) {
                    if (method_exists($this->model->$method(), $submethod = str_replace($method.'.', '', $field))) {
                        $this->model->$method()->$submethod();

                        $summary_fields[$field] = $fieldTitle;
                        continue;
                    }
                }
            }

            if (is_numeric($field)) {
                $field = $fieldTitle;
                $fieldTitle = Str::title($fieldTitle);
            }

            $summary_fields[$field] = $fieldTitle;
        }

        if (count($summary_fields)) {
            return $summary_fields;
        }

        return [$this->model->getKeyName() => $this->model->getKeyName()];
    }

    /**
     * Gets an Attribute by the provided key
     * on either the current model or a provided model instance.
     * 
     * @param string $key
     * @param mixed  $model
     * 
     * @return mixed
     */
    public function getAttribute($key, $model = false)
    {
        if (!$model) {
            $model = $this->model;
        }

        if ($this->hasGetAccessor($key)) {
            $method = 'get'.Str::studly($key).'Attribute';

            return $this->{$method}($model);
        }

        if ($this->hasRelatedKey($key, $model)) {
            return $this->relatedKey($key, $model);
        }

        return $model->getAttribute($key);
    }

    /**
     * Returns a raw Attribute from the Models
     * array of Attributes if it exists, otherwise,
     * falls back to getAttribute.
     * 
     * @param  string  $key  
     * @param  boolean $model 
     * 
     * @return mixed
     */
    public function getAttributeFromArray($key, $model = false)
    {
        if (!$model) {
            $model = $this->model;
        }

        if (array_key_exists($key, $attributes = $model->getAttributes())) {
            return $attributes[$key];
        }

        return $this->getAttribute($key, $model);
    }

    /**
     * Determine if a get accessor exists for an attribute.
     *
     * @param string $key
     * 
     * @return bool
     */
    public function hasGetAccessor($key)
    {
        return method_exists($this, 'get'.Str::studly($key).'Attribute');
    }

    /**
     * Determines if a key resolved a related Model.
     * 
     * @param string $key
     * @param mixed  $model
     * 
     * @return bool
     */
    public function hasRelatedKey($key, $model = false)
    {
        if (!$model) {
            $model = $this->model;
        }

        if (($methodBreaker = strpos($key, '.')) !== false) {
            $method = substr($key, 0, $methodBreaker);
            if (method_exists($model, $method)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Resolves a relation based on the key provided,
     * either on the current model or a provided model instance.
     * 
     * @param string $key
     * @param mixed  $model
     * 
     * @return mixed
     */
    public function relatedKey($key, $model = false)
    {
        if (!$model) {
            $model = $this->model;
        }

        if (($methodBreaker = strpos($key, '.')) !== false) {
            $method = substr($key, 0, $methodBreaker);
            if (method_exists($model, $method)) {
                if (method_exists($model->$method, $submethod = str_replace($method.'.', '', $key))) {
                    return $model->$method->$submethod();
                }

                if (isset($model->$method->$submethod)) {
                    return $model->$method->$submethod;
                }

                return $model->getRelationValue($method);
            }
        }

        return false;
    }

    /**
     * Set a given attribute on the model.
     *
     * @param string $key
     * @param mixed  $value
     */
    public function setAttribute($key, $value)
    {
        if ($this->hasSetMutator($key)) {
            $method = 'set'.Str::studly($key).'Attribute';

            return $this->{$method}($value);
        }

        $this->model->attributes[$key] = $value;
    }

    /**
     * Determine if a set mutator exists for an attribute.
     *
     * @param string $key
     * 
     * @return bool
     */
    public function hasSetMutator($key)
    {
        return method_exists($this, 'set'.Str::studly($key).'Attribute');
    }

    /**
     * Returns a DefaultWidget instance based on the
     * currently ManagedModel.
     * 
     * @return DefaultWidget
     */
    public function defaultWidget()
    {
        return new DefaultWidget($this);
    }
}
