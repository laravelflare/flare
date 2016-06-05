<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Administration Configuration
    |--------------------------------------------------------------------------
    | 
    | 'admin_title' : The title of your admin panel, usually your sites name.
    |
    | 'admin_url'   : Admin path without slashes, for instance:
    |                 'admin' would be available at http://example.com/admin
    |
    | 'admin_theme' : Choose an admin theme from the following colours:
    |                 'red', 'blue', 'green', 'yellow', 'black'.
    |
    */
    'admin_title' => 'Laravel Flare',
    'admin_url' => 'admin',
    'admin_theme' => 'red',
    /*
    |--------------------------------------------------------------------------
    | Administration Classes
    |--------------------------------------------------------------------------
    |
    | This array of Admin classes allows you to define all of your
    | Flare administration sections which will be made available in the Flare
    | admin panel. Hopefully we will replace the need for these to be
    | manually defined in the future with some crazy autoloading.
    |
    */
    'admin' => [

    ],

    /*
    |--------------------------------------------------------------------------
    | Administration Widgets
    |--------------------------------------------------------------------------
    |
    | This array of Admin Widget Classes
    | 
    | Example of Base WidgetAdmin:
    |       \LaravelFlare\Flare\Admin\Widgets\WidgetAdmin::class,
    |
    */
    'widgets' => [

    ],

    /*
    |--------------------------------------------------------------------------
    | Permissions
    |--------------------------------------------------------------------------
    |
    | Class to bind to the Permissionable Contract
    |
    */
    'permissions' => \LaravelFlare\Flare\Permissions\Permissions::class,

    /*
    |--------------------------------------------------------------------------
    | Policies
    |--------------------------------------------------------------------------
    |
    | This is an array of policies to register and the admin class to register
    | them against. Policies allow you to restrict certain areas of your
    | admin panel from being accessed by certain user types, for certain
    | request types or even actions.
    | 
    | Example Policy Registration:
    |       \LaravelFlare\Flare\Admin\Models\Users\UserAdmin::class =>
    |       \LaravelFlare\Flare\Admin\Models\Users\UserPolicy::class,
    |
    */
    'policies' => [

    ],

    /*
    |--------------------------------------------------------------------------
    | Flare Core Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration which is not Application specific, you probably don't 
    | need to change anything here! But feel free to play :)
    |
    */
    'show' => [
        'github' => true,
        'login' => true,
        'notifications' => true,
        'version' => true,
    ],
    
];
