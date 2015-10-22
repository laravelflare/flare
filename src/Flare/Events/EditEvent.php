<?php

namespace LaravelFlare\Flare\Events;

use Illuminate\Queue\SerializesModels;

class EditEvent extends Event
{
    use SerializesModels;

    /**
     * Model.
     * 
     * @var Model
     */
    public $model;

    /**
     * Create a new event instance.
     */
    public function __construct()
    {
    }
}
