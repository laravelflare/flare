<?php

namespace LaravelFlare\Flare\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event handler mappings for the application.
     *
     * @var array
     */
    protected $listen = [
                        LaravelFlare\Flare\Events\AfterCreate::class,
                        LaravelFlare\Flare\Events\AfterDelete::class,
                        LaravelFlare\Flare\Events\AfterEdit::class,
                        LaravelFlare\Flare\Events\AfterSave::class,
                        LaravelFlare\Flare\Events\BeforeCreate::class,
                        LaravelFlare\Flare\Events\BeforeDelete::class,
                        LaravelFlare\Flare\Events\BeforeEdit::class,
                        LaravelFlare\Flare\Events\BeforeSave::class,
                        LaravelFlare\Flare\Events\ModelCreate::class,
                        LaravelFlare\Flare\Events\ModelDelete::class,
                        LaravelFlare\Flare\Events\ModelEdit::class,
                        LaravelFlare\Flare\Events\ModelSave::class,
                        LaravelFlare\Flare\Events\ModelView::class,
                    ];

    /**
     * The subscriber classes to register.
     *
     * @var array
     */
    protected $subscribe = [];

    /**
     * Register any other events for your application.
     *
     * @param \Illuminate\Contracts\Events\Dispatcher $events
     */
    public function boot(DispatcherContract $events)
    {
        parent::boot($events);
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
        //
    }

    /**
     * Get the events and handlers.
     *
     * @return array
     */
    public function listens()
    {
        return $this->listen;
    }
}
