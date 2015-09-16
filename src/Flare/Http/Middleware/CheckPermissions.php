<?php

namespace Flare\Http\Middleware;

use Closure;
use Illuminate\Contracts\Routing\Middleware;
use Flare\Permissions\Permissions;
use Flare\Exceptions\PermissionsException;

class CheckPermissions implements Middleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     * 
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // I think we should register a Permissions Facade... and the permissions 
        // implementation should be defineable. That way we have have different
        // PermissionProviders: Code based, CMS Based, LDAP, etc?
        //  //  // Code Based example:
        //          /**
        //           * User can only view if their ID is odd
        //           */
        //          public function canView() {
        //              if (Auth::id() % 2 == 0) {
        //                  return false;
        //              }
        //              
        //              return true;
        //          }
        //  //  // 
        if (!Permissions::check()) {
            // I havn't decided how we should handle permissions failures yet,
            // Perhaps we simply provide a `Permissions Denied` page?
            // I also don't like idea of being redirected... Ideally we provide
            // an error message and give the user an opportunity to `correct`
            // their access privileges (login as another user or relogin) 
            // without losing their POST data etc.
            // 
            // Imagine how much of a pain in the arse it would be if you've just
            // typed out a several thousand word blog article and you are logged
            // out when you attempt to publish... and it's all gawwwnnn! :(
            // 
            // Lots of potential handlers could be used:
            // return redirect('/admin/login');
            // \App::abort(401, 'Not authenticated');
            throw new PermissionsException('Permission denied!');
        }

        return $next($request);
    }
}
