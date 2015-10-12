<?php

namespace LaravelFlare\Flare\Http\Middleware;

use Closure;
use Illuminate\Contracts\Routing\Middleware;
use LaravelFlare\Flare\Contracts\PermissionsInterface;
use LaravelFlare\Flare\Exceptions\PermissionsException;

class CheckPermissions implements Middleware
{
    /**
     * __construct
     *
     * Create a new Permissions Instance
     * 
     * @param PermissionsInterface $permissions
     */
    public function __construct(PermissionsInterface $permissions)
    {
        $this->permissions = $permissions;
    }

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
        if (!$this->permissions->check()) {
            throw new PermissionsException('Permission denied!');
        }

        return $next($request);
    }
}
