<?php

namespace LaravelFlare\Flare\Http\Controllers\Edge;

use Flare;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use LaravelFlare\Flare\Admin\AdminManager;
use LaravelFlare\Flare\Admin\Widgets\WidgetAdminManager;
use LaravelFlare\Flare\Http\Controllers\FlareController;
use LaravelFlare\Flare\Permissions\Permissions;
use Response;

class AdminController extends FlareController
{
    use AuthenticatesUsers {
        AuthenticatesUsers::redirectPath insteadof ResetsPasswords;
        AuthenticatesUsers::credentials insteadof ResetsPasswords;
        AuthenticatesUsers::guard insteadof ResetsPasswords;
    }
    use ResetsPasswords;
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
     * Show the login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function postLogin(Request $request)
    {
        return $this->login($request);
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
     * Send a reset link to the given user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function sendResetLinkEmail(Request $request)
    {
        $this->validateEmail($request);

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $response = $this->broker()->sendResetLink(
            $this->credentials($request)
        );

        return $response == Password::RESET_LINK_SENT
                    ? $this->sendResetLinkResponse($request, $response)
                    : $this->sendResetLinkFailedResponse($request, $response);
    }

    /**
     * Get the response for a successful password reset link.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $response
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    protected function sendResetLinkResponse(Request $request, $response)
    {
        return back()->with('status', trans($response));
    }

    /**
     * Get the response for a failed password reset link.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $response
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    protected function sendResetLinkFailedResponse(Request $request, $response)
    {
        return back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => trans($response)]);
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
    protected function loginRedirect()
    {
        if (Permissions::check()) {
            return redirect()->intended(Flare::adminUrl());
        }

        return redirect('/');
    }
    
    /**
     * Validate the email for the given request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function validateEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);
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
