<?php

namespace LaravelFlare\Flare\Http\Middleware;

use Closure;
use Response;
use LaravelFlare\Flare\Admin\AdminManager;

class CheckModelFound
{
    /**
     * Currently Requested ModelAdmin.
     */
    protected $modelAdmin;

    /**
     * Create a new filter instance.
     */
    public function __construct(AdminManager $adminManager)
    {
        if (!$adminManager->getAdminInstance() instanceof \LaravelFlare\Flare\Admin\Models\ModelAdmin) {
            return;
        }

        $this->modelAdmin = $adminManager->getAdminInstance();
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
        if (!$this->modelAdmin->find(\Route::getCurrentRoute()->parameter('one'))) {
            return Response::view('flare::admin.404', [], 404);
        }

        return $next($request);
    }
}
