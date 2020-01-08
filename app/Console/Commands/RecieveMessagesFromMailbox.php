<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\RecieveMessagesFromMailbox as MailboxJob;

class RecieveMessagesFromMailbox extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mail:process';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run jobs to process email';

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
        (new MailboxJob())->handle();
    }
}
