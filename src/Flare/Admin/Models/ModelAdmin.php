<?php

namespace LaravelFlare\Flare\Admin\Models;

use LaravelFlare\Flare\Admin\Admin;
use LaravelFlare\Flare\Exceptions\ModelAdminException;
use LaravelFlare\Flare\Contracts\ModelAdmin\ModelWriteableInterface;

class ModelAdmin extends Admin implements ModelWriteableInterface
{
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
     * List of managed {@link Model}s.
     *
     * Note: This must either be a single Namespaced String
     * or an Array of Namespaced Strings
     * 
     * @var array|string
     */
    protected $managedModels = '';

    /**
     * The current model manager.
     *
     * @var \LaravelFlare\Flare\Admin\Models\ManagedModel
     */
    protected $modelManager;

    /**
     * The current model to be managed.
     * 
     * @var Model
     */
    protected $model;

    /**
     * Class Prefix used for matching and removing term
     * from user provided Admin sections.
     *
     * Note: This is actually a suffix, we might change the terminology
     * for this later although it would obviously be a breaking change.
     * Change it up early or don't change it all!
     *
     * @var string
     */
    const CLASS_PREFIX = 'Admin';

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
            $parameters = [
                            'prefix' => $managedModel->urlPrefix(),
                            'as' => $managedModel->urlPrefix(),
                            'modelManager' => get_class($managedModel),
                            'model' => $managedModel->managedModel,
                        ];

            \Route::group($parameters, function() {
                \Route::controller('/', $this->getController());
            });
        }
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
        if (!$this->modelManager) {
            return;
        }

        if ($modelName = $this->getRequested('model')) {
            return new $modelName();
        }

        return new $this->modelManager->managedModel();
    }

    /**
     * Returns a Model Manager Instance.
     * 
     * @return \LaravelFlare\Flare\Admin\Models\ManagedModel
     */
    public function modelManager()
    {
        if ($modelManagerName = $this->getRequested('modelManager')) {
            return new $modelManagerName();
        }

        $modelManagerName = $this->defaultManagedModel();

        return new $modelManagerName();
    }

    /**
     * Returns the default Managed Model.
     *
     * @return string
     */
    protected function defaultManagedModel()
    {
        if (!is_array($this->managedModels)) {
            return $this->managedModels;
        }

        return $this->managedModels[0];
    }

    /**
     * Returns a collection of the Managed Models.
     * 
     * @return \Illuminate\Support\Collection
     */
    public function getManagedModels()
    {
        if (is_array($this->managedModels)) {
            return collect($this->managedModels);
        }

        return collect([$this->managedModels]);
    }
}
