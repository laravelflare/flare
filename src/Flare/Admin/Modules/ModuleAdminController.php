<?php

namespace LaravelFlare\Flare\Admin\Modules;

use LaravelFlare\Flare\Http\Controllers\FlareController;

class ModuleAdminController extends FlareController
{
    /**
     * __construct.
     * 
     * @param ModelAdminCollection $modelAdminCollection
     */
    public function __construct()
    {
        // Must call parent __construct otherwise 
        // we need to redeclare checkpermissions
        // middleware for authentication check
        parent::__construct();
    }

    /**
     * Index page for Module.
     * 
     * @return \Illuminate\Http\Response
     */
    public function getIndex()
    {
        return view('flare::admin.module.index', [

        ]);
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
        parent::missingMethod();
    }
}
