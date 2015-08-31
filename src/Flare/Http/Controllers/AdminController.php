<?php

namespace AdenFraser\Flare\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use AdenFraser\Flare\Admin\ModelAdminCollection;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;

/**
 * I kind of feel that this file should be
 * \AdenFraser\Flare\Admin\Http\Controllers
 * But really, we will only do that if we add a frontend
 * to the CMS rather than just a backend
 */
class AdminController extends BaseController
{
    use DispatchesJobs, ValidatesRequests;

    protected $modelAdminCollection;

    public function __construct(ModelAdminCollection $modelAdminCollection)
    {
        $this->modelAdminCollection = $modelAdminCollection;
    }

    /*public function getLogin()
    {
        // I'd like to move this to be triggered by middleware and redirect to a FlareAuthController...
        echo '<h1>Time to login</h1>'; die();
    }*/

    public function getIndex()
    {
        $data = [
            'modelAdminCollection' => $this->modelAdminCollection,
        ];

        return view('flare::admin.dashboard', $data);
    }
}
