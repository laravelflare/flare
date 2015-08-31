<?php

namespace AdenFraser\Flare\Admin;

use App\Models\User as User;
use \Route;
use Illuminate\Support\Str;

abstract class ModelAdmin
{
    /**
     * List of managed {@link Model}s 
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
     * Title of Model Admin
     *
     * @var string
     */
    protected $title = null;

    /**
     * Title of Model Admin
     *
     * @var string
     */
    protected $pluralTitle = null;

    /**
     * URL Prefix Model Admin
     *
     * @var string
     */
    protected $urlPrefix = null;

    /**
     * __construct
     */
    public function __construct()
    {
        //$this->setUpManagedModels();
    }

    public function model($modelName = null)
    {
        if (!isset($this->managedModels) || $this->managedModels === null) {
            return null; // Return a NullModel for Bantz?
        }

        if (!is_array($modelName = $this->managedModels)) {
            return new $modelName();
        }

        return new $modelName();
    }

    // /**
    //  * Determines if our $managedModels is an array or not,
    //  * if it is not, it will attempt to create a single
    //  * model instance. Otherwise it will loop the
    //  * $managedModels array and create objects
    //  *
    //  * @return
    //  */
    // private function setUpManagedModels()
    // {
    //     if (!isset($this->managedModels) || !is_array($this->managedModels)) {
    //         $this->singleManagedModel();
    //     }

    //     $this->loopManagedModels();
    // }

    // /**
    //  * If $managedModels is not set (null), or is false
    //  * we will use newAutoManagedModel() to determine
    //  * this ModelAdmins appropriate class.
    //  * 
    //  * @return
    //  */
    // private function singleManagedModel()
    // {
    //     if (!isset($this->managedModels) || !$this->managedModels) {
    //         echo 'here';
    //         $this->newAutoManagedModel();
    //     }

    //     $this->newManagedModel($this->managedModels);
    // }

    // /**
    //  * Loops teh array of $managedModels
    //  * 
    //  * @return 
    //  */
    // private function loopManagedModels()
    // {
    //     foreach ($this->loopManagedModels as $managedModel) {
    //         $this->newManagedModel($managedModel);
    //     }
    // }

    // /**
    //  * Automatically create a managedModel instance
    //  * from this ModelAdmin's classname 
    //  * @return
    //  */
    // private function newAutoManagedModel()
    // {
    //     $model = str_replace('Admin', '',  static::ShortName());
    //     echo $model; die();
    //     $this->$$model = new $model();
    // }

    // /**
    //  * Creates a new Managed Model instance
    //  * 
    //  * @param  $model 
    //  * @return
    //  */
    // private function newManagedModel($model)
    // {
    //     $this->$$model = new $model();
    // }

    /**
     * Register the routes for this ModelAdmin
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
        Route::group(['prefix' => static::UrlPrefix(), 'namespace' => get_called_class(), 'as' => static::UrlPrefix(), /*'before' => 'admin_auth'*/], function()
        {
            // We chould check if the ModelAdminController file exists in the user's App
            // If it does... load it. 
            //      Route::controller('/', '\AdenFraser\Flare\Admin\?Controller');
            // Otherwise, use the default ModelAdminController
            Route::controller('/', '\AdenFraser\Flare\Admin\ModelAdminController');
        });
    }

    /**
     * ShortName of a ModelAdmin Class
     *
     * @return string
     */
    public static function ShortName()
    {
        return (new \ReflectionClass(new static))->getShortName();
    }

    /**
     * Title of a ModelAdmin Class
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
     * Plural of the ModelAdmin Class Title
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
     * URL to a ModelAdmin Top Level Page
     *
     * @return string
     */
    public static function Url()
    {
        return url('admin/' . static::UrlPrefix());
    }

    /**
     * URL Prefix to a ModelAdmin Top Level Page
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
}
