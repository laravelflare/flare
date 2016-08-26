<?php

namespace LaravelFlare\Flare\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
                            \LaravelFlare\Flare\Admin\Models\ModelAdmin::class => \LaravelFlare\Flare\Permissions\ModelAdminPolicy::class,
                        ];

    /**
     * Register the application's policies.
     */
    public function registerPolicies()
    {
        foreach (array_merge($this->policies, \Flare::config('policies')) as $key => $value) {
            Gate::policy($key, $value);
        }
    }
}
