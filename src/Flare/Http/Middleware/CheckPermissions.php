<?php

namespace LaravelFlare\Flare\Http\Middleware;

use Closure;
use LaravelFlare\Flare\Contracts\PermissionsInterface;
use LaravelFlare\Flare\Exceptions\PermissionsException;

class CheckPermissions
{
    /**
     * Create a new Permissions Instance
     * 
     * @var \LaravelFlare\Flare\Contracts\PermissionsInterface
     */
    protected $permissions;

    /**
     * __construct
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
