<?php

namespace LaravelFlare\Flare\Admin\Models;

use LaravelFlare\Flare\Http\Controllers\FlareController;
use LaravelFlare\Flare\Http\Requests\ModelAdminAddRequest;
use LaravelFlare\Flare\Http\Requests\ModelAdminEditRequest;
use LaravelFlare\Flare\Exceptions\PermissionsException as PermissionsException;
use LaravelFlare\Flare\Exceptions\ModelAdminWriteableException as WriteableException;
use LaravelFlare\Flare\Exceptions\ModelAdminValidationException as ValidationException;

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
     * __construct
     * 
     * @param ModelAdminCollection $modelAdminCollection
     */
    public function __construct(ModelAdminCollection $modelAdminCollection)
    {
        // Must call parent __construct otherwise 
        // we need to redeclare checkpermissions
        // middleware for authentication check
        parent::__construct($modelAdminCollection);

        $this->middleware('checkmodelfound', ['only' => ['getView', 'edit', 'delete']]);

        $this->modelAdmin = $this->modelAdminCollection->getModelAdminInstance();
        $this->managedModel = $this->modelAdmin->modelManager();
    }

    /**
     * Index page for ModelAdmin.
     * 
     * @return \Illuminate\Http\Response
     */
    public function getIndex()
    {
        return view('flare::admin.modelAdmin.index', [ 'modelAdmin' => $this->modelAdmin ]);
    }

    /**
     * Create a new Model Entry from ModelAdmin Create Page.
     * 
     * @return \Illuminate\Http\Response
     */
    public function getCreate()
    {
        return view('flare::admin.modelAdmin.create', [ 'modelAdmin' => $this->modelAdmin ]);
    }

    /**
     * Receive new Model Entry Post Data, validate it and return user.
     * 
     * @return \Illuminate\Http\Response
     */
    public function postCreate(ModelAdminAddRequest $request)
    {
        /*
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

        return redirect($this->modelAdmin->CurrentUrl())->with('notifications_below_header', [['type' => 'success', 'icon' => 'check-circle', 'title' => 'Success!', 'message' => 'The '.$this->modelAdmin->modelManager()->Title().' was successfully created.', 'dismissable' => false]]);
    }

    /**
     * View a Model Entry from ModelAdmin View Page.
     * 
     * @return \Illuminate\Http\Response
     */
    public function getView($modelitem_id)
    {
        return view('flare::admin.modelAdmin.view', [
            'modelAdmin' => $this->modelAdmin,
            'modelItem' => $this->model->find($modelitem_id),
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
            'modelAdmin' => $this->modelAdmin,
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
        /*
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

        return redirect($this->modelAdmin->CurrentUrl())->with('notifications_below_header', [['type' => 'success', 'icon' => 'check-circle', 'title' => 'Success!', 'message' => 'The '.$this->modelAdmin->modelManager()->Title().' was successfully updated.', 'dismissable' => false]]);
    }

    /**
     * Delete Model Entry from ModelAdmin Delete Page.
     *
     * @param int $modelitem_id
     * 
     * @return \Illuminate\Http\Response
     */
    public function getDelete($modelitem_id)
    {
        return view('flare::admin.modelAdmin.delete', [
            'modelAdmin' => $this->modelAdmin,
            'modelItem' => $this->model->find($modelitem_id),
        ]);
    }

    /**
     * Receive Model Entry Delete Post Data, validate it and return user.
     *
     * @param int $modelitem_id
     * 
     * @return \Illuminate\Http\Response
     */
    public function postDelete($modelitem_id)
    {
        /*
         * I don't like this, we should check Permissions with Middleware, then try and delete.
         */

        try {
            $this->modelAdmin->delete($modelitem_id);
        } catch (WriteableException $exception) {
            echo 'Writeable Exception: <br>';
            var_dump($exception);
        }

        return redirect($this->modelAdmin->CurrentUrl())->with('notifications_below_header', [['type' => 'success', 'icon' => 'check-circle', 'title' => 'Success!', 'message' => 'The '.$this->modelAdmin->modelManager()->Title().' was successfully removed.', 'dismissable' => false]]);
    }
}
