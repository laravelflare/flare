<?php

return [

    'site_title' => 'Laravel <b>Flare</b>',

    /*
    |--------------------------------------------------------------------------
    | Admin Configuration
    |--------------------------------------------------------------------------
    |
    | 'admin_url': Admin URL Path without slashes.
    | 'admin_theme': Choose an admin theme from the following colours:
    |                'red', 'blue', 'green', 'yellow', 'black'.
    |                Flare Default is 'red'.
    |
    */
    'admin_url' => 'admin',
    'admin_theme' => 'red',

    /*
    |--------------------------------------------------------------------------
    | Administration Classes
    |--------------------------------------------------------------------------
    |
    | This array of Admin classes allows you to define all of your
    | Flare administeration sections which will be made available in the Flare
    | admin panel. Hopefully we will replace the need for these to be
    | manually defined in the future with some crazy autoloading.
    |
    */
    'admin' => [
        //
    ],

    /*
    |--------------------------------------------------------------------------
    | Administration Widgets
    |--------------------------------------------------------------------------
    |
    | This array of Admin Widget Classes
    |
    */
    'widgets' => [
        // Base WidgetAdmin: LaravelFlare\Flare\Admin\Widgets\WidgetAdmin::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Permissions
    |--------------------------------------------------------------------------
    |
    | Class to bind to the PermissionsInterface
    |
    */
    'permissions' => \LaravelFlare\Flare\Permissions\Permissions::class,

    /*
    |--------------------------------------------------------------------------
    | Flare Core Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration which is not Application specific, you probably don't 
    | need to change anything here!
    |
    */
    'core_notifications' => true,
];
