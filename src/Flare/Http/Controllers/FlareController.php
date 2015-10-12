<?php

namespace LaravelFlare\Flare\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use LaravelFlare\Flare\Admin\AdminCollection;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;

abstract class FlareController extends BaseController
{
    use DispatchesJobs, ValidatesRequests;

    /**
     * AdminCollection.
     *
     * @var AdminCollection
     */
    protected $adminCollection;

    /**
     * __construct.
     * 
     * @param AdminCollection $adminCollection
     */
    public function __construct(AdminCollection $adminCollection)
    {
        $this->middleware('flareauthenticate');
        $this->middleware('checkpermissions');

        $this->adminCollection = $adminCollection;

        view()->share('adminCollection', $this->adminCollection);
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
