<?php

namespace LaravelFlare\Flare\Http\Middleware;

use Closure;
use LaravelFlare\Flare\Admin\AdminCollection;

class CheckModelFound
{
    /**
     * Currently Requested Model.
     */
    protected $model;

    /**
     * Create a new filter instance.
     */
    public function __construct(AdminCollection $adminCollection)
    {
        if ($adminCollection->getAdminInstance() instanceof \LaravelFlare\Flare\Admin\Models\ModelAdmin) {
            $this->model = $adminCollection->getAdminInstance()->model();
        } else {
            return;
        }
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
        if (!$this->model->find(\Route::getCurrentRoute()->getParameter('one'))) {
            return view('flare::admin.404', []);
        }

        return $next($request);
    }
}
