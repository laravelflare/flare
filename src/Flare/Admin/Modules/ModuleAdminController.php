<?php

namespace LaravelFlare\Flare\Admin\Modules;

use LaravelFlare\Flare\Admin\AdminCollection;
use LaravelFlare\Flare\Http\Controllers\FlareController;

class ModuleAdminController extends FlareController
{
    /**
     * Admin Instance.
     * 
     * @var 
     */
    protected $admin;

    /**
     * __construct.
     * 
     * @param AdminCollection $adminCollection
     */
    public function __construct(AdminCollection $adminCollection)
    {
        // Must call parent __construct otherwise 
        // we need to redeclare checkpermissions
        // middleware for authentication check
        parent::__construct($adminCollection);

        $this->admin = $this->adminCollection->getAdminInstance();
    }

    /**
     * Index page for Module.
     * 
     * @return \Illuminate\Http\Response
     */
    public function getIndex()
    {
        return view($this->admin->getView(), $this->admin->getViewData());
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
