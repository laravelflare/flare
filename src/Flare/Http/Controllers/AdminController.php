<?php

namespace JacobBaileyLtd\Flare\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Bus\DispatchesJobs;
use JacobBaileyLtd\Flare\Admin\Models\ModelAdminCollection;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Contracts\Auth\Guard;

/**
 * I kind of feel that this file should be
 * \JacobBaileyLtd\Flare\Admin\Http\Controllers
 * But really, we will only do that if we add a frontend
 * to the CMS rather than just a backend.
 */
class AdminController extends BaseController
{
    use AuthenticatesUsers, DispatchesJobs, ValidatesRequests;

    protected $auth;

    protected $modelAdminCollection;

    public function __construct(Guard $auth, ModelAdminCollection $modelAdminCollection)
    {
        $this->auth = $auth;
        
        //$this->middleware('flareauthenticate', ['except' => ['getLogin', 'postLogin']]);

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

    public function postLogin(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email', 'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if ($this->auth->attempt($credentials, $request->has('remember')))
        {
            return redirect()->intended(url('admin'));
        }

        return redirect(url('admin/login'))
                    ->withInput($request->only('email', 'remember'))
                    ->withErrors([
                        'email' => $this->getFailedLoginMessage(),
                    ]);
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
