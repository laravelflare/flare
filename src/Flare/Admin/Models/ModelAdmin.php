<?php

namespace LaravelFlare\Flare\Admin\Models;

use Illuminate\Support\Str;
use LaravelFlare\Flare\Admin\Admin;
use LaravelFlare\Flare\Admin\Widgets\DefaultWidget;
use LaravelFlare\Flare\Exceptions\ModelAdminException;
use LaravelFlare\Flare\Traits\ModelAdmin\ModelWriting;
use LaravelFlare\Flare\Traits\ModelAdmin\ModelCloning;
use LaravelFlare\Flare\Traits\ModelAdmin\ModelQuerying;
use LaravelFlare\Flare\Traits\Attributes\AttributeAccess;
use LaravelFlare\Flare\Traits\ModelAdmin\ModelValidating;
use LaravelFlare\Flare\Contracts\ModelAdmin\ModelWriteable;
use LaravelFlare\Flare\Contracts\ModelAdmin\ModelQueryable;
use LaravelFlare\Flare\Contracts\ModelAdmin\ModelCloneable;
use LaravelFlare\Flare\Contracts\ModelAdmin\ModelValidatable;
use LaravelFlare\Flare\Contracts\ModelAdmin\AttributesAccessable;

class ModelAdmin extends Admin implements AttributesAccessable, ModelWriteable, ModelQueryable, ModelValidatable, ModelCloneable
{
    use AttributeAccess, ModelWriting, ModelQuerying, ModelValidating, ModelCloning;

    /**
     * Class of Model to Manage.
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
    protected static $icon = '';

    /**
     * Validation Rules for onCreate, onEdit actions.
     * 
     * @var array
     */
    protected $rules = [];

    /**
     * Columns for Model.
     *
     * Defines which fields to show in the listing tables output.
     * 
     * @var array
     */
    protected $columns = [];

    /**
     * Columns for Model are Sortable.
     *
     * @var bool
     */
    protected $sortable = true;

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
     * The Policy used for the Model Authorization logic.
     *
     * This class should implement the ModelAdminPoliceable which
     * includes authorization checks for the create, view, edit and delete actions.
     * 
     * @var string
     */
    protected static $policy = '\LaravelFlare\Flare\Permissions\ModelAdminPolicy';

    /**
     * The current model to be managed.
     * 
     * @var Model
     */
    public $model;

    /**
     * __construct.
     */
    public function __construct()
    {
        if (!isset(static::$managedModel) || static::$managedModel === null) {
            throw new ModelAdminException('You have a ModelAdmin which does not have a model assigned to it. ModelAdmins must include a model to manage.', 1);
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
     * Returns the Route Paramets.
     * 
     * @return array
     */
    public function routeParameters()
    {
        return array_merge(parent::routeParameters(), [
                                                    'model' => $this->managedModel,
                                                ]);
    }

    /**
     * Formats and returns the Columns.
     *
     * This is really gross, I'm removing it soon.
     * 
     * @return
     */
    public function getColumns()
    {
        $columns = [];

        foreach ($this->columns as $field => $fieldTitle) {
            if (in_array($field, $this->model->getFillable())) {
                if (!$field) {
                    $field = $fieldTitle;
                    $fieldTitle = Str::title($fieldTitle);
                }
                $columns[$field] = $fieldTitle;
                continue;
            }

            // We can replace this with data_get() I believe.
            if (($methodBreaker = strpos($field, '.')) !== false) {
                $method = substr($field, 0, $methodBreaker);
                if (method_exists($this->model, $method)) {
                    if (method_exists($this->model->$method(), $submethod = str_replace($method.'.', '', $field))) {
                        $this->model->$method()->$submethod();

                        $columns[$field] = $fieldTitle;
                        continue;
                    }
                }
            }

            if (is_numeric($field)) {
                $field = $fieldTitle;
                $fieldTitle = Str::title($fieldTitle);
            }

            $columns[$field] = $fieldTitle;
        }

        if (count($columns)) {
            return $columns;
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
     * Determine if a get mutator exists for an attribute.
     *
     * @param string $key
     * 
     * @return bool
     */
    public function hasGetMutator($key)
    {
        return method_exists($this, 'get'.Str::studly($key).'Attribute');
    }

    /**
     * Determine if the Model Admin is sortable in it's list view.
     *
     * @param string $key
     * 
     * @return bool
     */
    public function isSortable()
    {
        return isset($this->sortable) && $this->sortable ? true : false;
    }
    
    /**
     * Determine if the Managed Model is using the SoftDeletes Trait.
     *
     * @return bool
     */
    public function hasSoftDeletes()
    {
        return in_array(
            \Illuminate\Database\Eloquent\SoftDeletes::class, class_uses_recursive(get_class(new static::$managedModel()))
        ) && in_array(
            \LaravelFlare\Flare\Traits\ModelAdmin\ModelSoftDeleting::class, class_uses_recursive(get_class($this))
        );
    }
}
