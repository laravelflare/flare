<?php

namespace LaravelFlare\Flare\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use LaravelFlare\Flare\Admin\Models\ModelAdminCollection;

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
     * __construct.
     * 
     * @param ModelAdminCollection $modelAdminCollection
     */
    public function __construct(ModelAdminCollection $modelAdminCollection)
    {
        $this->modelAdminCollection = $modelAdminCollection;

        $this->middleware('flareauthenticate');
        $this->middleware('checkpermissions');

        view()->share('modelAdminCollection', $this->modelAdminCollection);
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
