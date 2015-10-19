<?php

namespace LaravelFlare\Flare\Admin\Models;

use Illuminate\Support\Str;
use LaravelFlare\Flare\Admin\Admin;
use LaravelFlare\Flare\Admin\Widgets\DefaultWidget;
use LaravelFlare\Flare\Exceptions\ModelAdminException;
use LaravelFlare\Flare\Traits\ModelAdmin\ModelQueryable;
use LaravelFlare\Flare\Traits\ModelAdmin\ModelWriteable;
use LaravelFlare\Flare\Traits\Attributes\AttributeAccess;
use LaravelFlare\Flare\Contracts\ModelAdmin\ModelWriteableInterface;

class ModelAdmin extends Admin implements ModelWriteableInterface
{
    use AttributeAccess, ModelWriteable, ModelQueryable;

    /**
     * Class of Model to Manage
     * 
     * @var string
     */
    protected static $managedModel;

    /**
     * ModelAdmin Icon.
     *
     * Font Awesome Defined Icon, eg 'user' = 'fa-user'
     *
     * @var string
     */
    protected static $icon = 'user';

    /**
     * The Controller to be used by the Model Admin.
     *
     * This defaults to parent::getController()
     * if it has been left undefined. 
     * 
     * @var string
     */
    protected static $controller = '\LaravelFlare\Flare\Admin\Models\ModelAdminController';

    /**
     * Validation Rules for onCreate, onEdit actions.
     * 
     * @var array
     */
    protected $rules = [];

    /**
     * Summary Fields for Model.
     *
     * Defines which fields to show in the listing tables output.
     * 
     * @var array
     */
    protected $summary_fields = [];

    /**
     * The current model to be managed.
     * 
     * @var Model
     */
    protected $model;

    /**
     * __construct.
     */
    public function __construct()
    {
        if (!isset(static::$managedModel) || static::$managedModel === null) {
            throw new ModelAdminException('You have a ModelAdmin which does not have any managed models assigned to it. ModelAdmins must include at least one model to manage.', 1);
        }

        $this->model = $this->model();
    }

    /**
     * Returns a Model Instance.
     *
     * Note: We should revisit this as really we shouldn't
     * be returning a new instance of the object on every
     * request.
     *
     * @return Model
     */
    public function model()
    {
        return new static::$managedModel();
    }


    /**
     * Returns the Route Paramets 
     * 
     * @return array
     */
    public function routeParameters()
    {
        return array_merge(parent::routeParameters(), [
                                                    'model' => $this->managedModel
                                                ]);
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
     * array of Attributes
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
