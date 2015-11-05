<?php

namespace LaravelFlare\Flare\Http\Middleware;

use Closure;
use LaravelFlare\Flare\Admin\AdminManager;

class CheckModelFound
{
    /**
     * Currently Requested Model.
     */
    protected $model;

    /**
     * Create a new filter instance.
     */
    public function __construct(AdminManager $adminManager)
    {
        if (!$adminManager->getAdminInstance() instanceof \LaravelFlare\Flare\Admin\Models\ModelAdmin) {
            return;
        }

        $this->model = $adminManager->getAdminInstance()->model();
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
        if (isset($this->modelAdmin->softDeletingModel) && $this->modelAdmin->softDeletingModel) {
            return $this->handleSoftDeleteCheck();
        } 

        if (!$this->model->find(\Route::getCurrentRoute()->getParameter('one'))) {
            return view('flare::admin.404', []);
        }

        return $next($request);
    }

    /**
     * When a ModelAdmin implements Soft Deleting, this method
     * is used to check if the Model actually exists.
     * 
     * @return mixed
     */
    protected function handleSoftDeleteCheck()
    {
        if (!$this->model->withTrashed()->find(\Route::getCurrentRoute()->getParameter('one'))) {
            return view('flare::admin.404', []);
        }

        return $next($request);
    }
}
