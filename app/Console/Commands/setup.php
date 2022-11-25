<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class setup_admin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:setup-admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Setup the default configuration of the application';

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
     * @return int
     */
    public function handle()
    {
        return 0;
    }
}
