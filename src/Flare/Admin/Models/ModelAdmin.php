<?php

namespace LaravelFlare\Flare\Admin\Models;

use Illuminate\Support\Str;
use LaravelFlare\Flare\Admin\Admin;
use LaravelFlare\Flare\Traits\ModelAdmin\ModelSaving;
use LaravelFlare\Flare\Exceptions\ModelAdminException;
use LaravelFlare\Flare\Traits\ModelAdmin\ModelQuerying;
use LaravelFlare\Flare\Contracts\ModelAdmin\ModelQueryable;
use LaravelFlare\Flare\Admin\Attributes\AttributeCollection;

class ModelAdmin extends Admin implements ModelQueryable
{
    use ModelQuerying;
    use ModelSaving;

    /**
     * Class of Model to Manage.
     * 
     * @var string
     */
    protected $managedModel;

    /**
     * ModelAdmin Icon.
     *
     * Font Awesome Defined Icon, eg 'user' = 'fa-user'
     *
     * @var string
     */
    protected $icon = '';

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
     * Map Model Attributes to AttributeTypes with
     * additional parameters which will be output
     * as fields when viewing, editting or adding
     * a new model entry.
     * 
     * @var array
     */
    protected $fields = [];

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
    protected $controller = '\LaravelFlare\Flare\Admin\Models\ModelAdminController';

    /**
     * The Policy used for the Model Authorization logic.
     *
     * This class should implement the ModelAdminPoliceable which
     * includes authorization checks for the create, view, edit and delete actions.
     * 
     * @var string
     */
    protected $policy = '\LaravelFlare\Flare\Permissions\ModelAdminPolicy';

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
        $this->getManagedModel();

        $this->model = $this->model();

        $this->formatFields();
    }

    /**
     * Returns a Model Instance.
     * 
     * @return Model
     */
    public function model()
    {
        if (!$this->model) {
            $class = $this->getManagedModel();

            return $this->model = new $class();
        }

        return $this->model;
    }

    /**
     * Returns a New Model Instance.
     *
     * @return Model
     */
    public function newModel()
    {
        $class = self::getManagedModel();

        return new $class();
    }

    /**
     * Returns the Managed Model Class.
     * 
     * @return string
     */
    public function getManagedModel()
    {
        if (!isset($this->managedModel) || $this->managedModel === null) {
            throw new ModelAdminException('You have a ModelAdmin which does not have a model assigned to it. ModelAdmins must include a model to manage.', 1);
        }

        return $this->managedModel;
    }

    /**
     * Set the Managed Model Class.
     * 
     * @param string $managedModel
     */
    public function setManagedModel($managedModel = null)
    {
        $this->managedModel = $managedModel;
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
        if (!$key) {
            return;
        }

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
     * Returns an array of Attribute Fields ready for output.
     *
     * @param  string $type 
     * 
     * @return array
     */
    public function outputFields($type = 'view')
    {
        return $this->getFields();
    }

    /**
     * Gets the Managed Model Mapping.
     * 
     * @return array
     */
    public function getFields()
    {
        $this->setFields($this->fields);

        return $this->fields;
    }

    /**
     * Sets the Managed Model Mapping.
     * 
     * @param array $fields
     */
    public function setFields($fields = [])
    {
        $this->fields = $fields;

        $this->formatFields();
    }

    /**
     * Format the provided Attribute Fields into a more usable format.
     * 
     * @return void
     */
    protected function formatFields()
    {
        $fields = $this->fields;

        if (!$fields instanceof AttributeCollection) {
            $fields = new AttributeCollection($fields, $this);
        }

        return $this->fields = $fields->formatFields();
    }

    /**
     * Determine if the Model Admin is sortable in it's list view.
     * 
     * @return bool
     */
    public function isSortable()
    {
        return isset($this->sortable) && $this->sortable ? true : false;
    }

    /**
     * Determine if the Model Admin is sortable by a defined key / column.
     *
     * @param string $key
     * 
     * @return bool
     */
    public function isSortableBy($key)
    {
        // Sorting is not allowed on Model Admin
        if (!$this->isSortable()) {
            return false;
        }

        // Key results are mutated, so sorting is not available
        if ($this->model()->hasGetMutator($key) || $this->hasGetMutator($key)) {
            return false;
        }

        // Key is a relation, so sorting is not available 
        if (strpos($key, '.') !== false) {
            return false;
        }

        return true;
    }

    /**
     * Determine if the Model Admin has Viewing Capabilities.
     * 
     * @return bool
     */
    public function hasViewing()
    {
        return $this->hasTrait(\LaravelFlare\Flare\Traits\ModelAdmin\ModelViewing::class);
    }

    /**
     * Determine if the Model Admin has Creating Capabilities.
     * 
     * @return bool
     */
    public function hasCreating()
    {
        return $this->hasTrait(\LaravelFlare\Flare\Traits\ModelAdmin\ModelCreating::class);
    }

    /**
     * Determine if the Model Admin has Cloning Capabilities.
     * 
     * @return bool
     */
    public function hasCloning()
    {
        return $this->hasTrait(\LaravelFlare\Flare\Traits\ModelAdmin\ModelCloning::class);
    }

    /**
     * Determine if the Model Admin has Editting Capabilities.
     * 
     * @return bool
     */
    public function hasEditting()
    {
        return $this->hasTrait(\LaravelFlare\Flare\Traits\ModelAdmin\ModelEditting::class);
    }

    /**
     * Determine if the Model Admin has Deleting Capabilities.
     * 
     * @return bool
     */
    public function hasDeleting()
    {
        return $this->hasTrait(\LaravelFlare\Flare\Traits\ModelAdmin\ModelDeleting::class);
    }

    /**
     * Determine if the Managed Model is using the SoftDeletes Trait.
     *
     * This is guarded by hasDeleting, since we shouldn't allow SoftDeleting
     * without the deleting trait (even though it isn't really required).
     *
     * @return bool
     */
    public function hasSoftDeleting()
    {
        if (!$this->hasDeleting()) {
            return false;
        }

        $managedModelClass = $this->getManagedModel();

        return in_array(
            \Illuminate\Database\Eloquent\SoftDeletes::class, class_uses_recursive(get_class(new $managedModelClass()))
        ) && in_array(
            \LaravelFlare\Flare\Traits\ModelAdmin\ModelSoftDeleting::class, class_uses_recursive(get_class($this))
        );
    }

    /**
     * Determine if the Model Admin has Validating Capabilities.
     * 
     * @return bool
     */
    public function hasValidating()
    {
        return $this->hasTrait(\LaravelFlare\Flare\Traits\ModelAdmin\ModelValidating::class);
    }

    /**
     * Determine if the Managed Model has a Trait and Contract
     *
     * @return bool
     */
    public function hasTraitAndContract($trait = null, $contract = null)
    {
        return ($this->hasTrait($trait) && $this->hasContract($contract));
    }

    /**
     * Returns whether the current ModelAdmin has a given trait.
     * 
     * @param  string  $trait  
     * 
     * @return boolean        
     */
    public function hasTrait($trait = null)
    {
        if (!$trait) {
            return;
        }

        return in_array($trait, class_uses_recursive(get_class($this)));
    }

    /**
     * Returns whether the current ModelAdmin has a given contract.
     * 
     * @param  string  $contract  
     * 
     * @return boolean        
     */
    public function hasContract($contract = null)
    {
        if (!$trait) {
            return;
        }
        
        $managedModelClass = $this->getManagedModel();
    }
}
