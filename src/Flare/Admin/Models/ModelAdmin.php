<?php

namespace LaravelFlare\Flare\Admin\Models;

use Route;
use Illuminate\Support\Str;
use LaravelFlare\Flare\Admin\Admin;
use LaravelFlare\Flare\Traits\Permissionable;
use LaravelFlare\Flare\Contracts\PermissionsContract;
use LaravelFlare\Flare\Exceptions\ModelAdminException;
use LaravelFlare\Flare\Traits\ModelAdmin\ModelWriteable;
use LaravelFlare\Flare\Traits\ModelAdmin\ModelValidation;
use LaravelFlare\Flare\Traits\Attributes\AttributeAccess;
use LaravelFlare\Flare\Contracts\ModelAdmin\ModelWriteableContract;
use LaravelFlare\Flare\Contracts\ModelAdmin\ModelValidationContract;

class ModelAdmin extends Admin implements PermissionsContract, ModelValidationContract, ModelWriteableContract
{
    use AttributeAccess, ModelValidation, ModelWriteable, Permissionable;

    /**
     * List of managed {@link Model}s.
     *
     * Note: This must either be a single Namespaced String
     * or an Array of Namespaced Strings
     *
     * Perhaps in the future we will allow App\Models\Model::class format aswell!
     * 
     * @var array|string
     */
    protected $managedModels = null;

    /**
     * The current model to be managed.
     * 
     * @var
     */
    protected $model;

    /**
     * The current model managed.
     *
     * @var
     */
    protected $modelManager;

    /**
     * Title of Model Admin.
     *
     * @var string
     */
    protected $title = null;

    /**
     * Title of Model Admin.
     *
     * @var string
     */
    protected $pluralTitle = null;

    /**
     * URL Prefix Model Admin.
     *
     * @var string
     */
    protected $urlPrefix = null;

    /**
     * __construct.
     */
    public function __construct()
    {
        if (!isset($this->managedModels) || $this->managedModels === null) {
            throw new ModelAdminException('You have a ModelAdmin which does not have any managed models assigned to it. ModelAdmins must include at least one model to manage.', 1);
        }

        $this->modelManager = $this->modelManager();
        $this->model = $this->model();
    }

    /**
     * This doesn't work as we are instantiating a new model instance everytime
     * which means we're receiving an empty object. DUh. Too much Aberlour for me.
     */
    public function model()
    {
        if (!$this->modelManager) {
            return;
        }

        if ($modelName = $this->getRequestedModel()) {
            return new $modelName();
        }

        return new $this->modelManager->managedModel();
    }

    public function getRequestedModel()
    {
        if (!\Route::current()) {
            return;
        }

        $currentAction = \Route::current()->getAction();

        if (isset($currentAction['model'])) {
            return $currentAction['model'];
        }

        return;
    }

    public function modelManager()
    {
        if (!is_array($this->managedModels)) {
            $modelManagerName = $this->managedModels;

            return new $modelManagerName();
        }

        if ($modelManagerName = $this->getRequestedModelManager()) {
            return new $modelManagerName();
        }

        $modelManagerName = $this->managedModels[0];

        return new $modelManagerName();
    }

    public function getRequestedModelManager()
    {
        if (!\Route::current()) {
            return;
        }

        $currentAction = \Route::current()->getAction();

        if (isset($currentAction['modelManager'])) {
            return $currentAction['modelManager'];
        }

        return;
    }

    public function getManagedModels()
    {
        if (is_array($this->managedModels)) {
            return collect($this->managedModels);
        }

        return collect($this->managedModels);
    }

    /**
     * Register the routes for this ModelAdmin.
     *
     * Default routes include, create:, read:, update:, delete:
     *
     * Also attempts to load in ModelAdminController
     * based on the ShortName of the class, for
     * overloading and adding additional routes
     * 
     * @return
     */
    public function registerRoutes()
    {
        // We will need to throw an exception if a ModelAdmin manages a Model which conflicts with an internal flare endpoint
        // such as (create, edit, view, delete etc) 
        Route::group(['prefix' => static::UrlPrefix(), 'namespace' => get_called_class(), 'as' => static::UrlPrefix()/*'before' => 'admin_auth'*/], function () {
            $this->registerSubRoutes();

            // We chould check if the ModelAdminController file exists in the user's App
            // If it does... load it. 
            //      Route::controller('/', '\LaravelFlare\Flare\Admin\?Controller');
            // Otherwise, use the default ModelAdminController
            Route::controller('/', '\LaravelFlare\Flare\Admin\Models\ModelAdminController');
        });
    }

    /**
     * Register subRoutes for ModelAdmin instances 
     * which have more than one managedModel.
     *
     * @return
     */
    public function registerSubRoutes()
    {
        if (!is_array($this->managedModels)) {
            return;
        }

        foreach ($this->managedModels as $managedModel) {
            $managedModel = new $managedModel();
            Route::group(['prefix' => $managedModel->UrlPrefix(), 'as' => $managedModel->UrlPrefix(), 'modelManager' => get_class($managedModel), 'model' => $managedModel->managedModel], function () {
                Route::controller('/', '\LaravelFlare\Flare\Admin\Models\ModelAdminController');
                // If first $modelName, redirect (301) back to base ModelAdmin
            });
        }
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
            return str_replace('Admin', '',  static::ShortName());
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
            return Str::plural(str_replace(' Admin', '',  static::Title()));
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
            return strtolower(str_replace('Admin', '',  static::PluralTitle()));
        }

        return static::$urlPrefix;
    }

    /**
     * URL to a ModelAdmin Top Level Page.
     *
     * @return string
     */
    public static function Url()
    {
        // Update 'admin' to use Admin config variable
        return url('admin/'.static::UrlPrefix());
    }

    /**
     * Relative URL to a ModelAdmin Top Level Page.
     *
     * @return string
     */
    public static function RelativeUrl()
    {
        // Update 'admin' to use Admin config variable
        return 'admin/'.static::UrlPrefix();
    }

    /**
     * Retrieves the Current ModelAdmin Route URL.
     *
     * @return string
     */
    public static function CurrentUrl()
    {
        return url(static::RelativeCurrentUrl());
    }

    /**
     * Retrieves the Current ModelAdmin Route URL.
     *
     * @return string
     */
    public static function RelativeCurrentUrl()
    {
        return \Route::current()->getPrefix();
    }

    /**
     * Handle dynamic static method calls into the ModelAdmin.
     *
     * @param string $method
     * @param array  $parameters
     * 
     * @return mixed
     */
    public static function __callStatic($method, $parameters)
    {
        $instance = new static();

        return call_user_func_array([$instance, $method], $parameters);
    }
}
