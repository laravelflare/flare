<?php

namespace LaravelFlare\Flare\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use LaravelFlare\Flare\Admin\Models\ModelAdminCollection;
use LaravelFlare\Flare\Admin\Modules\ModuleAdminCollection;
use LaravelFlare\Flare\Admin\Widgets\WidgetAdminCollection;

/**
 * I kind of feel that this file should be
 * \LaravelFlare\Flare\Admin\Http\Controllers
 * But really, we will only do that if we add a frontend
 * to the CMS rather than just a backend.
 */
class AdminController extends BaseController
{
    use AuthenticatesUsers, DispatchesJobs, ValidatesRequests;

    /**
     * Auth.
     * 
     * @var Guard
     */
    protected $auth;

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

    public function __construct(Guard $auth, ModelAdminCollection $modelAdminCollection, ModuleAdminCollection $moduleAdminCollection, WidgetAdminCollection $widgetAdminCollection)
    {
        $this->auth = $auth;

        $this->middleware('flareauthenticate', ['except' => ['getLogin', 'postLogin']]);
        $this->middleware('checkpermissions', ['except' => ['getLogin']]);

        $this->modelAdminCollection = $modelAdminCollection;
        $this->moduleAdminCollection = $moduleAdminCollection;
        $this->widgetAdminCollection = $widgetAdminCollection;

        view()->share('modelAdminCollection', $this->modelAdminCollection);
        view()->share('moduleAdminCollection', $this->moduleAdminCollection);
        view()->share('widgetAdminCollection', $this->widgetAdminCollection);
    }

    /**
     * Show the login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function getLogin()
    {
        return view('flare::admin.login');
    }

    /**
     * Processes the login form.
     *
     * @param Request $request [description]
     *
     * @return [type] [description]
     */
    public function postLogin(Request $request)
    {
        $this->validate($request, ['email' => 'required|email', 'password' => 'required']);

        $credentials = $request->only('email', 'password');

        if ($this->auth->attempt($credentials, $request->has('remember'))) {
            return redirect()->intended(url('admin'));
        }

        return redirect(url('admin/login'))
                    ->withInput($request->only('email', 'remember'))
                    ->withErrors([
                        'email' => $this->getFailedLoginMessage(),
                    ]);
    }

    /**
     * Log the user.
     *
     * @return \Illuminate\Http\Response
     */
    public function getLogout()
    {
        $this->auth->logout();

        return redirect('/');
    }

    /**
     * Show the Dashboard.
     * 
     * @return \Illuminate\Http\Response
     */
    public function getIndex()
    {
        return view('flare::admin.dashboard', ['modelAdminCollection' => $this->modelAdminCollection]);
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
