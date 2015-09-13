<?php

namespace JacobBaileyLtd\Flare\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use JacobBaileyLtd\Flare\Admin\Models\ModelAdminCollection;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;

/**
 * I kind of feel that this file should be
 * \JacobBaileyLtd\Flare\Admin\Http\Controllers
 * But really, we will only do that if we add a frontend
 * to the CMS rather than just a backend.
 */
class AdminController extends BaseController
{
    use AuthenticatesUsers, DispatchesJobs, ValidatesRequests;

    protected $modelAdminCollection;

    public function __construct(ModelAdminCollection $modelAdminCollection)
    {
        $this->middleware('checkpermissions', ['except' => ['getLogin']]);

        $this->modelAdminCollection = $modelAdminCollection;
    }

    /**
     * Show the application login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function getLogin()
    {
        return view('flare::admin.login');
    }

    /**
     * Show the Dashboard.
     * 
     * @return \Illuminate\Http\Response
     */
    public function getIndex()
    {
        $data = [
            'modelAdminCollection' => $this->modelAdminCollection,
        ];

        return view('flare::admin.dashboard', $data);
    }
}
