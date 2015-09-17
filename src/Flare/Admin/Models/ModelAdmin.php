<?php

namespace LaravelFlare\Flare\Admin\Models;

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
     * Perhaps in the future we will allow App\Models\Model::class format aswell!
     * 
     * @var array|string
     */
    protected $managedModels = null;

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

        if ($modelName = $this->getRequestedModel()) {
            return new $modelName();
        }

        return new $this->modelManager->managedModel();
    }

    /**
     * Returns the Requested Model as a string.
     * 
     * @return string
     */
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

    /**
     * Returns a Model Manager Instance.
     *
     * Note: We should revisit this as really we shouldn't
     * be returning a new instance of the object on every
     * request.
     * 
     * @return \LaravelFlare\Flare\Admin\ManagedModel
     */
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

    /**
     * Returns the Requested Model Manager as a string.
     * 
     * @return string|void
     */
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
