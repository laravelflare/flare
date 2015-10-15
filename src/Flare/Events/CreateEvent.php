<?php

namespace LaravelFlare\Flare\Events;

use LaravelFlare\Flare\Events\Event;
use Illuminate\Queue\SerializesModels;

class CreateEvent extends Event
{
    use SerializesModels;

    /**
     * Post.
     * 
     * @var Post
     */
    public $post;

    /**
     * Create a new event instance.
     */
    public function __construct()
    {

    }
}
