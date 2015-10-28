<?php

namespace LaravelFlare\Flare\Http\Middleware;

use Closure;
use LaravelFlare\Flare\Admin\AdminManager;
use LaravelFlare\Flare\Contracts\Permissionable;
use LaravelFlare\Flare\Exceptions\PermissionsException;

class CheckPermissions
{
    /**
     * Create a new Permissions Instance.
     * 
     * @var \LaravelFlare\Flare\Contracts\Permissionable
     */
    protected $permissions;

    /**
     * __construct.
     * 
     * @param Permissionable $permissions
     */
    public function __construct(Permissionable $permissions)
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
        if ($class = AdminManager::getAdminInstance()) {
            $class = get_class($class);
        }

        if (!$this->permissions->check($class)) {
            throw new PermissionsException('Permission denied!');
        }

        return $next($request);
    }
}
