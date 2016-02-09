<?php

namespace LaravelFlare\Flare\Console\Commands;

use Illuminate\Console\Command;

class MakeUserCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a new user';

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
        $email = $this->ask('Please provide your email (defaults to user@example.com)', 'user@example.com');
        $password = $this->ask('Please provide a password (defaults to password)', 'password');

        $authModel = config('auth.model');

        if (!get_class($authProvider = \Auth::getProvider()) === \Illuminate\Auth\EloquentUserProvider::class || !($authModel = $authProvider->getModel())) {
            $this->warn('To create a new admin user you must use Eloquent as your Auth Provider');

            return;
        }

        if ((new $authModel())->create(['name' => $name, 'email' => $email, 'password' => bcrypt($password)])) {
            $this->info('All done!');

            return;
        }

        $this->error('Something went wrong... Please try again.');
    }
}
