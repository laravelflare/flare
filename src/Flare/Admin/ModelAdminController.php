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
        // Must call parent __construct otherwise 
        // we need to redeclare checkpermissions
        // middleware
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
     * Receive new Model Entry Post Data, validate it and return user
     * 
     * @return \Illuminate\Http\Response
     */
    public function postCreate()
    {
        // Do something like this:   
        try
        {
            // Perhaps we could change this to ->create, ->edit and ->delete
            $this->modelAdmin->create('User', $data); // And perhaps 1st arg could be Model OR Data, since ModelAdmin's managing a single model do not need that. 
            // Or we could be awesome and autodetect the Model... perhaps some hidden input.
        }
        catch (Exception $exception)
        {
            // Probably validation redirect here
        }
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
     * Receive Model Entry Update Post Data, validate it and return user
     * 
     * @return \Illuminate\Http\Response
     */
    public function postEdit()
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
     * Receive Model Entry Delete Post Data, validate it and return user
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
