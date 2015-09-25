<?php

namespace LaravelFlare\Flare\Admin\Models;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use LaravelFlare\Flare\Admin\Admin;
use LaravelFlare\Flare\Traits\Permissionable;
use LaravelFlare\Flare\Contracts\PermissionsContract;
use LaravelFlare\Flare\Traits\ModelAdmin\ModelWriteable;
use LaravelFlare\Flare\Traits\ModelAdmin\ModelValidation;
use LaravelFlare\Flare\Traits\Attributes\AttributeAccess;
use LaravelFlare\Flare\Contracts\ModelAdmin\ModelWriteableContract;
use LaravelFlare\Flare\Contracts\ModelAdmin\ModelValidationContract;

abstract class ManagedModel extends Admin implements PermissionsContract, ModelValidationContract, ModelWriteableContract
{
    use AttributeAccess, ModelValidation, ModelWriteable, Permissionable;

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
     * The number of models to return for pagination.
     *
     * @var int
     */
    protected $perPage = 15;

    /**
     * Order By - Column/Attribute to OrderBy
     *
     * Primary Key of Model by default
     * 
     * @var string
     */
    protected $orderBy;

    /**
     * Sort By - Either Desc or Asc
     * 
     * @var string
     */
    protected $sortBy;

    /**
     * Class Prefix used for matching and removing term
     * from user provided Admin sections
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
            throw new Exception('You have a ManagedModel which does not have a model assigned to it.', 1);
        }

        $this->model = new $this->managedModel();

        if ($id && $this->model) {
            $this->managedModel()->find($id) ?: new $this->managedModel();
        }
    }

    /**
     * Returns Model Items, either all() or paginated().
     *
     * Ordered by Managed Model orderBy and sortBy methods
     * 
     * @return
     */
    public function items()
    {
        if ($this->perPage > 0) {
            return $this->model->orderBy(
                                            $this->orderBy(),
                                            $this->sortBy()
                                        )->paginate($this->perPage);
        }

        return $this->model->orderBy(
                                        $this->orderBy(),
                                        $this->sortBy()
                                    )->all();
    }

    /**
     * Return Managed Model OrderBy.
     *
     * Primary key is default.
     *
     * @return string
     */
    protected function orderBy()
    {
        if ($this->orderBy) {
            return $this->orderBy;
        }
        
        return $this->model->getKeyName();
    }

    /**
     * Return Managed Model SortBy (Asc or Desc).
     *
     * Descending is default.
     * 
     * @return string
     */
    protected function sortBy()
    {
        if ($this->sortBy == 'asc') {
            return 'asc';
        }

        return 'desc';
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

    public function hasRelatedKey($key, $model = false)
    {
        if (!$model) {
            $model = $this->model;
        }

        if (($methodBreaker = strpos($key, '.')) !== false) {
            $method = substr($key, 0, $methodBreaker);
            if (method_exists($model, $method)) {
                // If we get this far we assume the relatedKey to actually be a relation,
                // in practice it might not be.
                return true;
            }
        }

        return false;
    }

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
     * Get the number of models to return per page.
     *
     * @return int
     */
    public function getPerPage()
    {
        return $this->perPage;
    }

    /**
     * Set the number of models to return per page.
     *
     * @param int $perPage
     */
    public function setPerPage($perPage)
    {
        $this->perPage = $perPage;
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

        if ($this->isJsonCastable($key) && !is_null($value)) {
            $value = json_encode($value);
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
     * Handle dynamic method calls to the Managed Model.
     *
     * @param string $method
     * @param array  $parameters
     * 
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        /*if (starts_with($method, 'update') && ends_with($method, 'Attribute') && $this->hasView($key = substr(substr($method, 0, -9), 6))) {
            return call_user_func_array(array($this, 'getUpdateAttribute'), array_merge([$key], $parameters));
        }*/
    }
}
