<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;

class MakeUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new user';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $name = $this->ask('Your name?');
        $email = $this->ask('Your Email?');
        $password = $this->secret('Choose password?');
        $password_confirm = $this->secret('Confirm password?');
        if ($password_confirm == $password)
        {
            User::create([
                'name' => $name,
                'email' => $email,
                'password' => bcrypt($password)
            ]);
        }
        else
        {
            $this->error('Passwords do not match!');
        }
        

    }
}
