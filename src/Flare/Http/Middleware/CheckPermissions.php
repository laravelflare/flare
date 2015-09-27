<?php

namespace LaravelFlare\Flare\Http\Middleware;

use Closure;
use Illuminate\Contracts\Routing\Middleware;
use LaravelFlare\Flare\Permissions\Permissions;
use LaravelFlare\Flare\Exceptions\PermissionsException;

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
        if (!Permissions::check()) {
            throw new PermissionsException('Permission denied!');
        }

        return $next($request);
    }
}
