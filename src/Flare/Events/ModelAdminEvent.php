<?php

namespace LaravelFlare\Flare\Events;

use LaravelFlare\Flare\Events\Event;
use Illuminate\Queue\SerializesModels;

class ModelAdminEvent extends Event
{
    /**
     * Model Admin Instance
     * 
     * @var \LaravelFlare\Flare\Admin\Models\ModelAdmin
     */
    protected $modelAdmin;

    /**
     * Create a new event instance.
     *
     * @param \LaravelFlare\Flare\Admin\Models\ModelAdmin $modelAdmin
     */
    public function __construct(ModelAdmin $modelAdmin)
    {
        $this->modelAdmin = $modelAdmin;
    }
}
