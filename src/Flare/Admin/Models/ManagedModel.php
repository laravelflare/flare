<?php

namespace JacobBaileyLtd\Flare\Admin\Models;

use Illuminate\Support\Str;
use JacobBaileyLtd\Flare\Traits\Permissionable;
use JacobBaileyLtd\Flare\Contracts\PermissionsContract;
use JacobBaileyLtd\Flare\Traits\ModelAdmin\ModelWriteable;
use JacobBaileyLtd\Flare\Traits\ModelAdmin\ModelValidation;
use JacobBaileyLtd\Flare\Traits\Attributes\AttributeAccess;
use JacobBaileyLtd\Flare\Contracts\ModelAdmin\ModelWriteableContract;
use JacobBaileyLtd\Flare\Contracts\ModelAdmin\ModelValidationContract;

abstract class ManagedModel implements PermissionsContract, ModelValidationContract, ModelWriteableContract
{
    use AttributeAccess, ModelValidation, ModelWriteable, Permissionable;

    /**
     * Managed Model Instance
     * 
     * @var string
     */
    public $managedModel;

    /**
     * Model Instance
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

    public function __construct()
    {
        if (!isset($this->managedModel) || $this->managedModel === null) {
            throw new Exception('You have a ManagedModel which does not have a model assigned to it.', 1);
        }

        $this->model = new $this->managedModel();
    }

    /**
     * ShortName of a ModelAdmin Class.
     *
     * @return string
     */
    public static function ShortName()
    {
        return (new \ReflectionClass(new static()))->getShortName();
    }

    /**
     * Title of a ModelAdmin Class.
     *
     * @return string
     */
    public static function Title()
    {
        if (!isset(static::$title) || !static::$title) {
            return str_replace('Managed', '',  static::ShortName());
        }

        return static::$title;
    }

    /**
     * Plural of the ModelAdmin Class Title.
     *
     * @return string
     */
    public static function PluralTitle()
    {
        if (!isset(static::$pluralTitle) || !static::$pluralTitle) {
            return Str::plural(str_replace(' Managed', '',  static::Title()));
        }

        return static::$pluralTitle;
    }

    /**
     * URL Prefix to a ModelAdmin Top Level Page.
     *
     * @return string
     */
    public static function UrlPrefix()
    {
        if (!isset(static::$urlPrefix) || !static::$urlPrefix) {
            return strtolower(str_replace('Managed', '',  static::PluralTitle()));
        }

        return static::$urlPrefix;
    }

    /**
     * Returns Model Items, either all() or paginated() 
     * 
     * @return
     */
    public function items()
    {
        if ($this->perPage > 0) {
            return $this->model->paginate($this->perPage);
        }

        return $this->model->all();
    }

    /**
     * Formats and returns the Summary fields
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

            if(($methodBreaker = strpos($field, '.'))!==false) {
                $method = substr($field, 0, $methodBreaker);

                if (method_exists($this->model, $method)) {
                    
                    if(method_exists($this->model->$method(), $submethod = str_replace($method.'.', '', $field))) {
                        $this->model->$method()->$submethod();

                        $summary_fields[$field] = $fieldTitle;
                    } 

                } 
                
            }

        }

        if (count($summary_fields)) {
            return $summary_fields;
        }

        return [$this->model->primaryKey];
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
     * @param  int   $perPage
     * @return void
     */
    public function setPerPage($perPage)
    {
        $this->perPage = $perPage;
    }


    /**
     * Set a given attribute on the model.
     *
     * @param  string  $key
     * @param  mixed   $value
     * 
     * @return void
     */
    public function setAttribute($key, $value)
    {
        if ($this->hasSetMutator($key)) {
            $method = 'set'.Str::studly($key).'Attribute';

            return $this->{$method}($value);
        }

        if ($this->isJsonCastable($key) && ! is_null($value)) {
            $value = json_encode($value);
        }

        $this->model->attributes[$key] = $value;
    }

    /**
     * Determine if a set mutator exists for an attribute.
     *
     * @param  string  $key
     * 
     * @return bool
     */
    public function hasSetMutator($key)
    {
        return method_exists($this, 'set'.Str::studly($key).'Attribute');
    }

    /**
     * Handle dynamic method calls to the Managed Model
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
