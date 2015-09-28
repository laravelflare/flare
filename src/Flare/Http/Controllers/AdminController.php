<?php

namespace LaravelFlare\Flare\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Foundation\Bus\DispatchesJobs;
use LaravelFlare\Flare\Admin\Models\ModelAdminCollection;
use LaravelFlare\Flare\Admin\Modules\ModuleAdminCollection;
use LaravelFlare\Flare\Admin\Widgets\WidgetAdminCollection;
use LaravelFlare\Flare\Traits\Http\Controllers\AuthenticatesAndResetsPasswords;

/**
 * I kind of feel that this file should be
 * \LaravelFlare\Flare\Admin\Http\Controllers
 * But really, we will only do that if we add a frontend
 * to the CMS rather than just a backend.
 */
class AdminController extends FlareController
{
    use AuthenticatesAndResetsPasswords, DispatchesJobs;

    /**
     * Auth.
     * 
     * @var Guard
     */
    protected $auth;

    /**
     * __construct.
     * 
     * @param Guard                 $auth
     * @param ModelAdminCollection  $modelAdminCollection
     * @param ModuleAdminCollection $moduleAdminCollection
     */
    public function __construct(Guard $auth, ModelAdminCollection $modelAdminCollection, ModuleAdminCollection $moduleAdminCollection)
    {
        parent::__construct($modelAdminCollection, $moduleAdminCollection);

        $this->auth = $auth;

        $this->middleware('flareauthenticate', ['except' => ['getLogin', 'postEmail', 'getEmail', 'postEmail']]);
        $this->middleware('checkpermissions', ['except' => ['getLogin', 'postLogin', 'getEmail', 'postEmail']]);
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
     * @return \Illuminate\Http\Response
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
     * Display the form to request a password reset link.
     *
     * @return \Illuminate\Http\Response
     */
    public function getEmail()
    {
        return view('flare::admin.password');
    }

    /**
     * Show the Dashboard.
     * 
     * @return \Illuminate\Http\Response
     */
    public function getIndex()
    {
        return view('flare::admin.dashboard', ['widgetAdminCollection' => (new WidgetAdminCollection())]);
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
