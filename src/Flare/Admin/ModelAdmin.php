<?php

namespace JacobBaileyLtd\Flare\Admin;

use Route;
use Illuminate\Support\Str;
use JacobBaileyLtd\Flare\Traits\Permissionable;
use JacobBaileyLtd\Flare\Contracts\PermissionsContract;
use JacobBaileyLtd\Flare\Exceptions\ModelAdminException;
use JacobBaileyLtd\Flare\Traits\ModelAdmin\ModelWriteable;
use JacobBaileyLtd\Flare\Traits\ModelAdmin\ModelValidation;
use JacobBaileyLtd\Flare\Traits\Attributes\AttributeAccess;
use JacobBaileyLtd\Flare\Contracts\ModelAdmin\ModelWriteableContract;
use JacobBaileyLtd\Flare\Contracts\ModelAdmin\ModelValidationContract;

abstract class ModelAdmin implements PermissionsContract, ModelValidationContract, ModelWriteableContract
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
     * Temporary array of Input recieved during a POST request.
     *
     * @var array
     */
    public $input = [];

    /**
     * __construct.
     */
    public function __construct()
    {
        if (!isset($this->managedModels) || $this->managedModels === null) {
            throw new ModelAdminException('You have a ModelAdmin which does not have any managed models assigned to it. ModelAdmins must include at least one model to manage.', 1);
        }
    }

    /**
     * This doesn't work as we are instantiating a new model instance everytime
     * which means we're receiving an empty object. DUh. Too much Aberlour for me.
     */
    public function model($modelName = null)
    {
        if (!is_array($modelName = $this->managedModels)) {
            return new $modelName();
        }

        // Need to detect 


        $modelName = $this->managedModels[0];

        return new $modelName(); // This is stupid. Blame the Talisker. We need to check the modelName existance, and ensure it is not NULL.
    }

    public function getManagedModels()
    {
        if (is_array($this->managedModels)) {
            return $this->managedModels;
        }

        return [$this->managedModels];
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
            //      Route::controller('/', '\JacobBaileyLtd\Flare\Admin\?Controller');
            // Otherwise, use the default ModelAdminController
            Route::controller('/', '\JacobBaileyLtd\Flare\Admin\ModelAdminController');
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

        foreach ($this->managedModels as $modelName) {
            $modelUrl = strtolower(substr($modelName, strrpos($modelName, '\\') + 1));
            Route::group(['prefix' => $modelUrl, 'as' => $modelUrl], function () {
                Route::controller('/', '\JacobBaileyLtd\Flare\Admin\ModelAdminController');
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
     * Handle dynamic method calls  ModelAdmin (and its children).
     *
     * @param string $method
     * @param array  $parameters
     * 
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        // I'd like to implement Permissions on the Attribute view, edit and update... 
        if (starts_with($method, 'view') && ends_with($method, 'Attribute')) {
            return call_user_func_array(array($this, 'getViewAttribute'), array_merge(array($method), $parameters));
        }

        if (starts_with($method, 'edit') && ends_with($method, 'Attribute')) {
            return call_user_func_array(array($this, 'getEditAttribute'), array_merge(array($method), $parameters));
        }

        if (starts_with($method, 'update') && ends_with($method, 'Attribute') && $this->hasView($key = substr(substr($method, 0, -9), 6))) {
            return call_user_func_array(array($this, 'getUpdateAttribute'), array_merge([$key], $parameters));
        }
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
