<?php

namespace LaravelFlare\Flare\Events;

use Illuminate\Queue\SerializesModels;

class SaveEvent extends Event
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
