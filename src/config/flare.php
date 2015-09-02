<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Administered Models
    |--------------------------------------------------------------------------
    |
    | This array of ModelAdmin class aliases allows you to define all of your
    | Flare administered Models which will be made available in the Flare
    | admin panel. Hopefully we will replace the need for these to be
    | manually defined in the future with some crazy autoloading.
    |
    */

    'models' => [
        AdenFraser\Flare\Admin\ModelAdmin::class,
        AdenFraser\Flare\Admin\ExampleAdmin::class,
        AdenFraser\Flare\Admin\Users\UserAdmin::class,
    ],

];
