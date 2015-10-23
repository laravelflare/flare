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
                        LaravelFlare\Flare\Events\AfterCreateEvent::class,
                        LaravelFlare\Flare\Events\AfterDeleteEvent::class,
                        LaravelFlare\Flare\Events\AfterEditEvent::class,
                        LaravelFlare\Flare\Events\AfterSaveEvent::class,
                        LaravelFlare\Flare\Events\BeforeCreateEvent::class,
                        LaravelFlare\Flare\Events\BeforeDeleteEvent::class,
                        LaravelFlare\Flare\Events\BeforeEditEvent::class,
                        LaravelFlare\Flare\Events\BeforeSaveEvent::class,
                        LaravelFlare\Flare\Events\CreateEvent::class,
                        LaravelFlare\Flare\Events\DeleteEvent::class,
                        LaravelFlare\Flare\Events\EditEvent::class,
                        LaravelFlare\Flare\Events\SaveEvent::class,
                        LaravelFlare\Flare\Events\ViewEvent::class,
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
     * @param  \Illuminate\Contracts\Events\Dispatcher  $events
     * @return void
     */
    public function boot(DispatcherContract $events)
    {
        parent::boot($events);
    }
    
    /**
     * Register the service provider.
     *
     * @return void
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
