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
        'email' => ['type' => 'email', 'length' => 255, 'required' => 'required'],
        'password' => ['type' => 'password', 'length' => 32, 'required' => 'required'],
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

Now when we view our output table, we can see our first user! Let's view that user...

So the password was saved as rawtext which isn't helpful at all. Flare allows you to define mutators specific to Managed Model instances (such as your ManagedUser), so the following:

    protected function setPasswordAttribute($value)
    {
        $this->model->setAttribute('password', bcrypt($value));
    }

Will bcrypt the provided password when the ManagedUser instance performs a save on the Model.

Let's go to Edit our user now and update their password - it will now be hashed, which can be verified by viewing the user again.