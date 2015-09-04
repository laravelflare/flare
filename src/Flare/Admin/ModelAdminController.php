<?php

namespace JacobBaileyLtd\Flare\Admin;

use JacobBaileyLtd\Flare\Http\Controllers\FlareController;

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
