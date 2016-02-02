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
        // Example of ModelAdmin:
        \LaravelFlare\Flare\Admin\Models\Users\UserAdmin::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Administration Attributes
    |--------------------------------------------------------------------------
    |
    | This array of Attribute classes includes the defined list of
    | attribute types which will be available in your ModelAdmin sections.
    |
    | You can add your own custom attributes here, replace or even remove
    | some of the defaults.
    |
    | Note: These classnames should be unique regardless of Namespace.
    |
    */
    'attributes' => [
        \LaravelFlare\Flare\Admin\Attributes\CheckboxAttribute::class,
        \LaravelFlare\Flare\Admin\Attributes\DateAttribute::class,
        \LaravelFlare\Flare\Admin\Attributes\DateTimeAttribute::class,
        \LaravelFlare\Flare\Admin\Attributes\EmailAttribute::class,
        \LaravelFlare\Flare\Admin\Attributes\FileAttribute::class,
        \LaravelFlare\Flare\Admin\Attributes\ImageAttribute::class,
        \LaravelFlare\Flare\Admin\Attributes\PasswordAttribute::class,
        \LaravelFlare\Flare\Admin\Attributes\RadioAttribute::class,
        \LaravelFlare\Flare\Admin\Attributes\SelectAttribute::class,
        \LaravelFlare\Flare\Admin\Attributes\TextareaAttribute::class,
        \LaravelFlare\Flare\Admin\Attributes\TextAttribute::class,
        \LaravelFlare\Flare\Admin\Attributes\TextMaskAttribute::class,
        \LaravelFlare\Flare\Admin\Attributes\TimeAttribute::class,
        \LaravelFlare\Flare\Admin\Attributes\WysiwygAttribute::class,
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
        // Example of Base WidgetAdmin: \LaravelFlare\Flare\Admin\Widgets\WidgetAdmin::class,
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
    | Policy Registration
    |
    */
    'policies' => [
        // Example of Policy:
        \LaravelFlare\Flare\Admin\Models\Users\UserAdmin::class => \LaravelFlare\Flare\Admin\Models\Users\UserPolicy::class,
    ],

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
