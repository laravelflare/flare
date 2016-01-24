<?php

namespace LaravelFlare\Flare\Console\Commands;

use Illuminate\Console\Command;

class MakeAdminCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a new admin user';

    /**
     * __construct.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Run the command.
     */
    public function fire()
    {
        $name = $this->ask('Please provide a username (defaults to admin)', 'admin');
        $email = $this->ask('Please provide your email (defaults to admin@example.com)', 'admin@example.com');
        $password = $this->ask('Please provide a password (defaults to password)', 'password');

        $authModel = config('auth.model');

        if (!get_class($authProvider = \Auth::getProvider()) === \Illuminate\Auth\EloquentUserProvider::class || !($authModel = $authProvider->getModel())) {
            $this->warn('To create a new admin user you must use Eloquent as your Auth Provider');

            return;
        }

        $authModel::unguard();

        if ((new $authModel())->create(['name' => $name, 'email' => $email, 'password' => bcrypt($password), 'is_admin' => true])) {
            $this->info('All done!');

            return;
        }

        $authModel::reguard();

        $this->error('Something went wrong... Please try again.');
    }
}
