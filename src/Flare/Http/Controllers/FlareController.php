<?php

namespace LaravelFlare\Flare\Http\Controllers;

use Response;
use LaravelFlare\Flare\Admin\AdminManager;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;

abstract class FlareController extends BaseController
{
    use DispatchesJobs, ValidatesRequests;

    /**
     * AdminManager.
     *
     * @var AdminManager
     */
    protected $adminManager;

    /**
     * __construct.
     * 
     * @param AdminManager $adminManager
     */
    public function __construct(AdminManager $adminManager)
    {
        $this->adminManager = $adminManager;

        view()->share('adminManager', $this->adminManager);
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
        return Response::view('flare::admin.404', [], 404);
    }
}
