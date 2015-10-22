<?php

namespace LaravelFlare\Flare\Admin\Notifications;

use LaravelFlare\Flare\Admin\Admin;

abstract class NotificationAdmin extends Admin
{
    /**
     * Type of Notification which can be one of the following:
     *
     * Notification Type: `info`, `success`, `warning`, `danger`
     *
     * Notification Colour Types: `primary`, `gray`, `navy`, `teal`, `purple`, `orange, `maroon`, `black`
     * 
     * @var string
     */
    protected $type;

    /**
     * Any font awesome icon class can be used, ommit the 'fa-' prefix.
     *
     * For instance: 
     *     `$icon = 'warning';` 
     *
     * Will output <i class="fa fa-warning"></i>
     * 
     * @var string
     */
    protected $icon;

    /**
     * The Title of your Notification, which is output wrapped in <h4> tags.
     * 
     * @var string
     */
    protected $title;

    /**
     * The Message to include with your Notification.
     * 
     * @var string
     */
    protected $message;

    /**
     * Whether the Notification is dismissable or not.
     * 
     * This will include a dismissable cross in the top right corner of
     * the notification box and allow users to dismiss the notification.
     * 
     * @var boolean
     */
    protected $dismissable;

    /**
     * Whether the Notification should persist until dismissed or not.
     *
     * By default Notifications appear once as flashdata and then no longer appear. 
     * If persists is set to true then the notification will continue to appear until
     * the user dismisses it.
     * 
     * @var boolean
     */
    protected $persists;

    /**
     * When the notification should expire.
     *
     * Persistable notifications should have an expiry date as they don't usually exist forever.
     * 
     * @var 
     */
    protected $expires;
}
