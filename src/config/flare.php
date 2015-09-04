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
        JacobBaileyLtd\Flare\Admin\ModelAdmin::class,
        //JacobBaileyLtd\Flare\Admin\ExampleAdmin::class,
        JacobBaileyLtd\Flare\Admin\Users\UserAdmin::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Administration Modules
    |--------------------------------------------------------------------------
    |
    | This array of Module Providers, coming soon
    |
    */
   'modules' => [

   ],

];
