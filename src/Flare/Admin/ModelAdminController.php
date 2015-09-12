<?php

namespace JacobBaileyLtd\Flare\Admin;

use JacobBaileyLtd\Flare\Http\Controllers\FlareController;
use JacobBaileyLtd\Flare\Http\Requests\ModelAdminAddRequest;
use JacobBaileyLtd\Flare\Http\Requests\ModelAdminEditRequest;
use JacobBaileyLtd\Flare\Exceptions\PermissionsException as PermissionsException;
use JacobBaileyLtd\Flare\Exceptions\ModelAdminWriteableException as WriteableException;
use JacobBaileyLtd\Flare\Exceptions\ModelAdminValidationException as ValidationException;

class ModelAdminController extends FlareController
{
    /**
     * ModelAdmin instance which has been resolved.
     * 
     * @var ModelAdmin
     */
    protected $modelAdmin;

    /**
     * ModelAdminCollection.
     *
     * @var ModelAdminCollection
     */
    protected $modelAdminCollection;

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

        $this->modelAdmin = $this->getModelAdminInstance();
        $this->modelAdminCollection = $modelAdminCollection;
    }

    /**
     * Index page for ModelAdmin.
     * 
     * @return \Illuminate\Http\Response
     */
    public function getIndex()
    {
        $data = [
            'modelAdminCollection' => $this->modelAdminCollection,
            'modelAdmin' => $this->modelAdmin,
        ];

        return view('flare::admin.modelAdmin.index', $data);
    }

    /**
     * Create a new Model Entry from ModelAdmin Create Page.
     * 
     * @return \Illuminate\Http\Response
     */
    public function getCreate()
    {
        $data = [
            'modelAdminCollection' => $this->modelAdminCollection,
            'modelAdmin' => $this->modelAdmin,
        ];

        return view('flare::admin.modelAdmin.create', $data);
    }

    /**
     * Receive new Model Entry Post Data, validate it and return user.
     * 
     * @return \Illuminate\Http\Response
     */
    public function postCreate(ModelAdminAddRequest $request)
    {
        $this->modelAdmin->input = $request->all();

        try {
            $this->modelAdmin->canCreate();
        } catch (PermissionsException $exception) {
            echo 'Permissions Exception: <br>';
            var_export($exception);
        }

        try {
            $this->modelAdmin->validate();
        } catch (ValidationException $exception) {
            echo 'Validation Exception: <br>';
            var_dump($exception);
        }

        try {
            $this->modelAdmin->create();
        } catch (WriteableException $exception) {
            echo 'Writeable Exception: <br>';
            var_dump($exception);
        }

        echo 'All done!';
    }

    /**
     * View a Model Entry from ModelAdmin View Page.
     * 
     * @return \Illuminate\Http\Response
     */
    public function getView()
    {
        $data = [
            'modelAdminCollection' => $this->modelAdminCollection,
            'modelAdmin' => $this->modelAdmin,
        ];

        return view('flare::admin.modelAdmin.view', $data);
    }

    /**
     * Edit Model Entry from ModelAdmin Edit Page.
     * 
     * @return \Illuminate\Http\Response
     */
    public function getEdit()
    {
        $data = [
            'modelAdminCollection' => $this->modelAdminCollection,
            'modelAdmin' => $this->modelAdmin,
        ];

        return view('flare::admin.modelAdmin.edit', $data);
    }

    /**
     * Receive Model Entry Update Post Data, validate it and return user.
     * 
     * @return \Illuminate\Http\Response
     */
    public function postEdit(ModelAdminEditRequest $request)
    {
    }

    /**
     * Delete Model Entry from ModelAdmin Delete Page.
     * 
     * @return \Illuminate\Http\Response
     */
    public function getDelete()
    {
        $data = [
            'modelAdminCollection' => $this->modelAdminCollection,
            'modelAdmin' => $this->modelAdmin,
        ];

        return view('flare::admin.modelAdmin.delete', $data);
    }

    /**
     * Receive Model Entry Delete Post Data, validate it and return user.
     * 
     * @return \Illuminate\Http\Response
     */
    public function postDelete()
    {
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

    /**
     * Returns an instance of the ModelAdmin.
     * 
     * @return ModelAdmin
     */
    private function getModelAdminInstance()
    {
        $className = \Route::current()->getAction()['namespace'];

        return new $className();
    }
}
