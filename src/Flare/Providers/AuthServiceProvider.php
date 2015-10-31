<?php

namespace LaravelFlare\Flare\Providers;

use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
                            LaravelFlare\Flare\Admin\Models\ModelAdmin::class => LaravelFlare\Flare\Permissions\ModelAdminPolicy::class,
                        ];

    /**
     * Register the application's policies.
     *
     * @param \Illuminate\Contracts\Auth\Access\Gate $gate
     */
    public function registerPolicies(GateContract $gate)
    {
        foreach (array_merge($this->policies, \Flare::config('policies')) as $key => $value) {
            $gate->policy($key, $value);
        }
    }

    /**
     * Register any application authentication / authorization services.
     *
     * @param \Illuminate\Contracts\Auth\Access\Gate $gate
     */
    public function boot(GateContract $gate)
    {
        $this->registerPolicies($gate);
    }
}
