<?php

namespace JacobBaileyLtd\Flare\Admin\Models;

use JacobBaileyLtd\Flare\Http\Controllers\FlareController;
use JacobBaileyLtd\Flare\Http\Requests\ModelAdminAddRequest;
use JacobBaileyLtd\Flare\Http\Requests\ModelAdminEditRequest;
use JacobBaileyLtd\Flare\Exceptions\PermissionsException as PermissionsException;
use JacobBaileyLtd\Flare\Exceptions\ModelAdminWriteableException as WriteableException;
use JacobBaileyLtd\Flare\Exceptions\ModelAdminValidationException as ValidationException;

class ModelAdminController extends FlareController
{
    /**
     * ModelAdminCollection.
     *
     * @var ModelAdminCollection
     */
    protected $modelAdminCollection;

    /**
     * ModelAdmin instance which has been resolved.
     * 
     * @var ModelAdmin
     */
    protected $modelAdmin;

    /**
     * ManagedModel instance.
     * 
     * @var ManagedModel
     */
    protected $managedModel;

    /**
     * Model instance.
     * 
     * @var Model
     */
    protected $model;

    /**
     * __construct.
     * 
     * @param ModelAdminCollection $modelAdminCollection
     */
    public function __construct(ModelAdminCollection $modelAdminCollection)
    {
        // Must call parent __construct otherwise 
        // we need to redeclare checkpermissions
        // middleware for authentication check
        parent::__construct();

        $this->modelAdminCollection = $modelAdminCollection;
        $this->modelAdmin = $this->modelAdminCollection->getModelAdminInstance();
        $this->managedModel = $this->modelAdmin->modelManager();
        $this->model = $this->managedModel->model;
    }

    /**
     * Index page for ModelAdmin.
     * 
     * @return \Illuminate\Http\Response
     */
    public function getIndex()
    {
        return view('flare::admin.modelAdmin.index', [
            'modelAdminCollection' => $this->modelAdminCollection,
            'modelAdmin' => $this->modelAdmin,
            'model' => $this->model,
        ]);
    }

    /**
     * Create a new Model Entry from ModelAdmin Create Page.
     * 
     * @return \Illuminate\Http\Response
     */
    public function getCreate()
    {
        return view('flare::admin.modelAdmin.create', [
            'modelAdminCollection' => $this->modelAdminCollection,
            'modelAdmin' => $this->modelAdmin,
            'model' => $this->model,
        ]);
    }

    /**
     * Receive new Model Entry Post Data, validate it and return user.
     * 
     * @return \Illuminate\Http\Response
     */
    public function postCreate(ModelAdminAddRequest $request)
    {
        /**
         * I don't like this, we should validate using the Request,
         * and check Permissions with Middleware, then try and create.
         */
        
        try {
            $this->modelAdmin->canCreate();
        } catch (PermissionsException $exception) {
            echo 'Permissions Exception: <br>';
            var_export($exception);
        }

        // try {
        //     $this->modelAdmin->validate();
        // } catch (ValidationException $exception) {
        //     echo 'Validation Exception: <br>';
        //     var_dump($exception);
        // }

        try {
            $this->modelAdmin->create();
        } catch (WriteableException $exception) {
            echo 'Writeable Exception: <br>';
            var_dump($exception);
        }

        return redirect($this->modelAdmin->CurrentUrl())->with('notifications_below_header', [ ['type' => 'success', 'icon' => 'check-circle', 'title' => 'Success!', 'message' => 'The '.$this->modelAdmin->modelManager()->Title() . ' was successfully created.', 'dismissable' => false] ]);
    }

    /**
     * View a Model Entry from ModelAdmin View Page.
     * 
     * @return \Illuminate\Http\Response
     */
    public function getView()
    {
        return view('flare::admin.modelAdmin.view', [
            'modelAdminCollection' => $this->modelAdminCollection,
            'modelAdmin' => $this->modelAdmin,
            'model' => $this->model,
        ]);
    }

    /**
     * Edit Model Entry from ModelAdmin Edit Page.
     *
     * @param int $modelitem_id
     * 
     * @return \Illuminate\Http\Response
     */
    public function getEdit($modelitem_id)
    {
        return view('flare::admin.modelAdmin.edit', [
            'modelAdminCollection' => $this->modelAdminCollection,
            'modelAdmin' => $this->modelAdmin,
            'model' => $this->model,
            'modelItem' => $this->model->find($modelitem_id),
        ]);
    }

    /**
     * Receive Model Entry Update Post Data, validate it and return user.
     * 
     * @param int $modelitem_id
     * 
     * @return \Illuminate\Http\Response
     */
    public function postEdit(ModelAdminEditRequest $request, $modelitem_id)
    {
        /**
         * I don't like this, we should validate using the Request,
         * and check Permissions with Middleware, then try and Edit.
         */

        try {
            $this->modelAdmin->canEdit();
        } catch (PermissionsException $exception) {
            echo 'Permissions Exception: <br>';
            var_export($exception);
        }

        // try {
        //     $this->modelAdmin->validate();
        // } catch (ValidationException $exception) {
        //     echo 'Validation Exception: <br>';
        //     var_dump($exception);
        // }

        try {
            $this->modelAdmin->edit($modelitem_id);
        } catch (WriteableException $exception) {
            echo 'Writeable Exception: <br>';
            var_dump($exception);
        }

        return redirect($this->modelAdmin->CurrentUrl())->with('notifications_below_header', [ ['type' => 'success', 'icon' => 'check-circle', 'title' => 'Success!', 'message' => 'The '.$this->modelAdmin->modelManager()->Title() . ' was successfully updated.', 'dismissable' => false] ]);
    }

    /**
     * Delete Model Entry from ModelAdmin Delete Page.
     *
     * @param  int $modelitem_id
     * 
     * @return \Illuminate\Http\Response
     */
    public function getDelete($modelitem_id)
    {
        return view('flare::admin.modelAdmin.delete', [
            'modelAdminCollection' => $this->modelAdminCollection,
            'modelAdmin' => $this->modelAdmin,
            'model' => $this->model,
            'modelItem' => $this->model->find($modelitem_id),
        ]);
    }

    /**
     * Receive Model Entry Delete Post Data, validate it and return user.
     *
     * @param  int $modelitem_id
     * 
     * @return \Illuminate\Http\Response
     */
    public function postDelete($modelitem_id)
    {
        /**
         * I don't like this, we should check Permissions with Middleware, then try and delete.
         */
        
        try {
            $this->modelAdmin->delete($modelitem_id);
        } catch (WriteableException $exception) {
            echo 'Writeable Exception: <br>';
            var_dump($exception);
        }

        return redirect($this->modelAdmin->CurrentUrl())->with('notifications_below_header', [ ['type' => 'success', 'icon' => 'check-circle', 'title' => 'Success!', 'message' => 'The '.$this->modelAdmin->modelManager()->Title() . ' was successfully removed.', 'dismissable' => false] ]);
    }

    /**
     * Method is called when the appropriate controller
     * method is unable to be found or called.
     * 
     * @param array $parameters
     * 
     * @return
     */
    public function missingMethod($parameters = array())
    {
        // Feel Free to Expand Here
        //var_dump($parameters);

        parent::missingMethod();
    }
}
