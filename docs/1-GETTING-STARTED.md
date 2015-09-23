# Getting Started

## Fresh Laravel Install
Run Migrations: `php artisan migrate`

## Including the Flare Service Provider and Resources
Add `LaravelFlare\Flare\FlareServiceProvider::class` to your Application Services Providers list (in config/app.php)

Publish assets and config with `php artisan vendor:publish`

## Creating your first Admin Section
`php artisan make:modeladmin UserAdmin`

`php artisan make:managedmodel ManagedUser`

In UserAdmin:
    protected $managedModels = [
        \App\Admin\Models\ManagedUser::class
    ];

In config/flare.php
    'modeladmins' => [
        \App\Admin\Models\UserAdmin::class,
    ],

Define field mapping in ManagedUser:
    protected $mapping = [
        'name' => ['type' => 'text', 'length' => 32, 'required' => 'required'],
        'email' => ['type' => 'email', 'length' => 255, 'requred' => 'required'],
        'password' => ['type' => 'password', 'length' => 32, 'requred' => 'required'],
    ];

You can now add your first entry to the database using Flare.

However, the output table isn't very helpful at all ... Let's fix that:

    protected $summary_fields = [
        'id' => 'ID',
        'name',
        'email',
        'created_at' => 'Created',
        'updated_at' => 'Updated',
    ];