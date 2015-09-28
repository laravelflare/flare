<?php

namespace LaravelFlare\Flare\Console\Commands;

use Illuminate\Console\Command;

class CreateUserCommand extends Command
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
     * Array of data to create user with
     * 
     * @var array
     */
    protected $data = [];

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
        $this->askName();
        $this->askEmail();
        $this->askPassword();

        $authModel = config('auth.model');

        if ((new $authModel())->create($this->data)) {
            $this->info('All done!');

            return;
        }

        $this->error('Something went wrong... Please try again.');
    }

    /**
     * Ask the user to define a name
     * 
     * @return void
     */
    private function askName()
    {
        $this->data['name'] = $this->ask('Please provide a username');

        if ($this->data['name'] == '') {
            $this->data['name'] = 'admin';
        }
    }

    /**
     * Ask the user to define their email
     * 
     * @return void
     */
    private function askEmail()
    {
        $this->data['email'] = $this->ask('Please provide your email');

        if ($this->data['email'] == '') {
            $this->data['email'] = 'tech.studio@jacobbailey.com';
        }
    }

    /**
     * Ask the user to define a password
     * 
     * @return void
     */
    private function askPassword()
    {
        $this->data['password'] = $this->ask('Please provide a password');

        if ($this->data['password'] == '') {
            $this->data['password'] = 'password';
        }
    }
}
