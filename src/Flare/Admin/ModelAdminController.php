<?php

namespace AdenFraser\Flare\Admin;

use \Route;
use Illuminate\Foundation\Bus\DispatchesJobs;
use AdenFraser\Flare\Admin\ModelAdminCollection;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;

class ModelAdminController extends BaseController
{
    use DispatchesJobs, ValidatesRequests;

    /**
     * ModelAdmin instance which has been resolved
     * 
     * @var ModelAdmin
     */
    protected $modelAdmin;

    /**
     * ModelAdminCollection 
     *
     * @var ModelAdminCollection
     */
    protected $modelAdminCollection;

    public function __construct(ModelAdminCollection $modelAdminCollection)
    {
        $this->modelAdmin = $this->getModelAdminInstance();
        $this->modelAdminCollection = $modelAdminCollection;

    }
  
    public function getIndex()
    {
        $data = [
            'modelAdminCollection' => $this->modelAdminCollection,
            'modelAdmin' => $this->modelAdmin,
        ];

        return view('flare::admin.modelAdmin.index', $data);
    }

    public function getCreate()
    {
        $data = [
            'modelAdminCollection' => $this->modelAdminCollection,
            'modelAdmin' => $this->modelAdmin,
        ];

        return view('flare::admin.modelAdmin.create', $data);
    }

    public function getView()
    {
        $data = [
            'modelAdminCollection' => $this->modelAdminCollection,
            'modelAdmin' => $this->modelAdmin,
        ];

        return view('flare::admin.modelAdmin.view', $data);
    }

    public function getEdit()
    {
        $data = [
            'modelAdminCollection' => $this->modelAdminCollection,
            'modelAdmin' => $this->modelAdmin,
        ];

        return view('flare::admin.modelAdmin.edit', $data);
    }

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
     * method is unable to be found or called
     * 
     * @param  array  $parameters
     * 
     * @return
     */
    public function missingMethod($parameters = array())
    {
        // Feel Free to Expand Here

        parent::missingMethod();
    }

    private function getModelAdminInstance()
    {
        $className = \Route::current()->getAction()['namespace']; 
        return new $className();
    }
}
