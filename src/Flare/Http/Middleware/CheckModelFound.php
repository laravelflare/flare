<?php

namespace LaravelFlare\Flare\Http\Middleware;

use Closure;
use LaravelFlare\Flare\Admin\Models\ModelAdminCollection;

class CheckModelFound
{
    /**
     * Currently Requested Model.
     */
    protected $model;

    /**
     * Create a new filter instance.
     */
    public function __construct(ModelAdminCollection $modelAdminCollection)
    {
        $this->model = $modelAdminCollection->getAdminInstance()->modelManager()->model;
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
