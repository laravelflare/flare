<?php

namespace LaravelFlare\Flare\Http\Controllers\LTS;

use Flare;
use Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Auth\Guard;
use LaravelFlare\Flare\Admin\AdminManager;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Auth\RegistersUsers;
use LaravelFlare\Flare\Permissions\Permissions;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use LaravelFlare\Flare\Http\Controllers\FlareController;
use LaravelFlare\Flare\Admin\Widgets\WidgetAdminManager;

class AdminController extends FlareController
{
    use AuthenticatesUsers;
    use ThrottlesLogins;
    use ResetsPasswords;
    use RegistersUsers;
    use DispatchesJobs;

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

        return view($view, ['widgets' => (new WidgetAdminManager())]);
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
    public function getEmail()
    {
        return view('flare::admin.password');
    }

    /**
     * Display the form to request a password reset link.
     *
     * @return \Illuminate\Http\Response
     */
    public function getReset()
    {
        return view('flare::admin.reset');
    }

    /**
     * Performs the login redirect action.
     *
     * If the authenticated user has admin permissions
     * then they will be redirected into the admin
     * panel. If they do no, they will be sent
     * to the homepage of the website.
     * 
     * @return \Illuminate\Http\RedirectReponse
     */
    public function redirectPath()
    {
        if (Permissions::check()) {
            return redirect()->intended(Flare::adminUrl());
        }

        return redirect('/');
    }

    /**
     * Get the path to the login route.
     *
     * @return string
     */
    public function loginPath()
    {
        return Flare::adminUrl('login');
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
        return Response::view('flare::admin.404', [], 404);
    }
}
