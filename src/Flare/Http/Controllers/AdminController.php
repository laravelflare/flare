<?php

namespace LaravelFlare\Flare\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Guard;
use LaravelFlare\Flare\Admin\AdminManager;
use Illuminate\Foundation\Bus\DispatchesJobs;
use LaravelFlare\Flare\Admin\Widgets\WidgetAdminManager;
use LaravelFlare\Flare\Traits\Http\Controllers\AuthenticatesAndResetsPasswords;

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
     * @param Guard        $auth
     * @param AdminManager $adminManager
     */
    public function __construct(Guard $auth, AdminManager $adminManager)
    {
        parent::__construct($adminManager);

        $this->auth = $auth;

        $this->middleware('flareauthenticate', ['except' => ['getLogin', 'postLogin', 'getEmail', 'postEmail']]);
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
     * @param Request $request
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
        $view = 'admin.dashboard';

        if (!view()->exists($view)) {
            $view = 'flare::'.$view;
        }

        return view($view, ['widgetAdminManager' => (new WidgetAdminManager())]);
    }

    /**
     * Method is called when the appropriate controller
     * method is unable to be found or called.
     * 
     * @param array $parameters
     * 
     * @return \Illuminate\Http\Response
     */
    public function missingMethod($parameters = array())
    {
        return view('flare::admin.404', []);
    }
}
