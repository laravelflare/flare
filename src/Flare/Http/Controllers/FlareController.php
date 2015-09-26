<?php

namespace LaravelFlare\Flare\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use LaravelFlare\Flare\Admin\Models\ModelAdminCollection;
use LaravelFlare\Flare\Admin\Modules\ModuleAdminCollection;

abstract class FlareController extends BaseController
{
    use DispatchesJobs, ValidatesRequests;

    /**
     * ModelAdminCollection.
     *
     * @var ModelAdminCollection
     */
    protected $modelAdminCollection;

    /**
     * ModuleAdminCollection.
     *
     * @var ModuleAdminCollection
     */
    protected $moduleAdminCollection;

    /**
     * __construct.
     * 
     * @param ModelAdminCollection $modelAdminCollection
     */
    public function __construct(ModelAdminCollection $modelAdminCollection, ModuleAdminCollection $moduleAdminCollection)
    {
        $this->middleware('flareauthenticate');
        $this->middleware('checkpermissions');
        
        $this->modelAdminCollection = $modelAdminCollection;
        $this->moduleAdminCollection = $moduleAdminCollection;

        view()->share('modelAdminCollection', $this->modelAdminCollection);
        view()->share('moduleAdminCollection', $this->moduleAdminCollection);
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
        return view('flare::admin.404', []);
    }
}
