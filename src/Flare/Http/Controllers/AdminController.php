<?php

namespace LaravelFlare\Flare\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Guard;
use LaravelFlare\Flare\Admin\AdminManager;
use Illuminate\Foundation\Bus\DispatchesJobs;
use LaravelFlare\Flare\Permissions\Permissions;
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
    }

    /**
     * Show the Dashboard.
     * 
     * @return \Illuminate\Http\Response
     */
    public function getDashboard()
    {
        $view = 'admin.dashboard';

        if (!view()->exists($view)) {
            $view = 'flare::'.$view;
        }

        return view($view, ['widgetAdminManager' => (new WidgetAdminManager())]);
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
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postLogin(Request $request)
    {
        $this->validate($request, ['email' => 'required|email', 'password' => 'required']);

        $credentials = $request->only('email', 'password');

        if ($this->auth->attempt($credentials, $request->has('remember'))) {
            return $this->loginRedirect();
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
     * @return \Illuminate\Http\RedirectReponse
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
    public function getReset()
    {
        return view('flare::admin.password');
    }

    /**
     * Performs the login redirect action.
     *
     * If the authenticated user has admin permissions
     * then they will be redirected into the admin
     * panel.If they do no, they will be sent
     * to the homepage of the website.
     * 
     * @return \Illuminate\Http\RedirectReponse
     */
    protected function loginRedirect()
    {
        if (Permissions::check()) {
            return redirect()->intended(\Flare::adminUrl());
        }

        return redirect('/');
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
